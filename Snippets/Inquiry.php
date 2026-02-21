/**
 * Teznevisan Inquiry Page Template Snippet for WPCode
 *
 * Registers a virtual page template for the Teznevisan inquiry form and
 * replaces the page content with a styled RTL form + FAQ section that
 * sends an email to multiple recipients.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template slug constant used in page meta.
 *
 * @var string
 */
if ( ! defined( 'TEZ_INQUIRY_TEMPLATE_SLUG' ) ) {
	define( 'TEZ_INQUIRY_TEMPLATE_SLUG', 'tez-inquiry-template.php' );
}

/**
 * Template name constant shown in the page template dropdown.
 *
 * @var string
 */
if ( ! defined( 'TEZ_INQUIRY_TEMPLATE_NAME' ) ) {
	define( 'TEZ_INQUIRY_TEMPLATE_NAME', 'قالب ثبت سفارش تزنویسان' );
}

/**
 * Register inquiry page template in the "Page Attributes → Template" dropdown.
 *
 * @param array<string,string> $templates Existing templates.
 * @return array<string,string> Modified templates including inquiry template.
 */
function tez_register_inquiry_page_template( $templates ) {
	if ( ! is_array( $templates ) ) {
		$templates = array();
	}
	$templates[ TEZ_INQUIRY_TEMPLATE_SLUG ] = TEZ_INQUIRY_TEMPLATE_NAME;
	return $templates;
}
add_filter( 'theme_page_templates', 'tez_register_inquiry_page_template' );

/**
 * Handle inquiry form submissions and render custom content
 * when the Teznevisan inquiry page template is selected.
 *
 * @param string $content Original page content.
 * @return string Filtered content.
 */
function tez_render_inquiry_page_content( $content ) {
	if ( is_admin() || ! is_singular( 'page' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$template = get_page_template_slug( get_queried_object_id() );
	if ( $template !== TEZ_INQUIRY_TEMPLATE_SLUG ) {
		return $content;
	}

	$errors     = array();
	$success    = false;
	$form_data  = array();
	$recipients = array(
		'teznevisancompany@gmail.com',
		'teznevisan@gmail.com',
		'Raminnamjoo@yahoo.com',
		'shoja.kord@yahoo.com',
		'maziyarid@gmail.com',
	);

	// Handle form submit.
	if ( isset( $_POST['tez_inquiry_submit'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$nonce_raw = isset( $_POST['tez_inquiry_nonce'] ) ? wp_unslash( $_POST['tez_inquiry_nonce'] ) : '';
		$nonce_ok  = $nonce_raw && wp_verify_nonce( sanitize_text_field( $nonce_raw ), 'tez_inquiry_submit' );

		if ( ! $nonce_ok ) {
			$errors[] = 'در ارسال فرم مشکلی پیش آمد. لطفاً صفحه را رفرش کرده و دوباره تلاش کنید.';
		} else {
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$raw = wp_unslash( $_POST );

			$form_data['full_name']    = isset( $raw['full_name'] ) ? sanitize_text_field( $raw['full_name'] ) : '';
			$form_data['phone']        = isset( $raw['phone'] ) ? sanitize_text_field( $raw['phone'] ) : '';
			$form_data['email']        = isset( $raw['email'] ) ? sanitize_email( $raw['email'] ) : '';
			$form_data['education']    = isset( $raw['education'] ) ? sanitize_text_field( $raw['education'] ) : '';
			$form_data['field']        = isset( $raw['field'] ) ? sanitize_text_field( $raw['field'] ) : '';
			$form_data['project_type'] = isset( $raw['project_type'] ) ? sanitize_text_field( $raw['project_type'] ) : '';
			$form_data['deadline']     = isset( $raw['deadline'] ) ? sanitize_text_field( $raw['deadline'] ) : '';
			$form_data['contact_way']  = isset( $raw['contact_way'] ) ? sanitize_text_field( $raw['contact_way'] ) : '';
			$form_data['description']  = isset( $raw['description'] ) ? wp_kses_post( $raw['description'] ) : '';

			if ( $form_data['full_name'] === '' ) {
				$errors[] = 'لطفاً نام و نام خانوادگی خود را وارد کنید.';
			}
			if ( $form_data['phone'] === '' ) {
				$errors[] = 'لطفاً شماره تماس خود را وارد کنید.';
			}

			if ( empty( $errors ) ) {
				$site_name = get_bloginfo( 'name' );
				$subject   = sprintf( 'فرم ثبت سفارش جدید از سایت %s', $site_name );

				$message  = '<html><body style="direction:rtl;text-align:right;font-family:tahoma,arial;">';
				$message .= '<h2>جزئیات سفارش جدید</h2>';
				$message .= '<table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;border-color:#e5e7eb;min-width:400px;">';
				$message .= '<tr><th align="right">نام و نام خانوادگی</th><td>' . esc_html( $form_data['full_name'] ) . '</td></tr>';
				$message .= '<tr><th align="right">شماره تماس</th><td>' . esc_html( $form_data['phone'] ) . '</td></tr>';

				if ( $form_data['email'] !== '' ) {
					$message .= '<tr><th align="right">ایمیل</th><td>' . esc_html( $form_data['email'] ) . '</td></tr>';
				}
				if ( $form_data['education'] !== '' ) {
					$message .= '<tr><th align="right">مقطع تحصیلی</th><td>' . esc_html( $form_data['education'] ) . '</td></tr>';
				}
				if ( $form_data['field'] !== '' ) {
					$message .= '<tr><th align="right">رشته / گرایش</th><td>' . esc_html( $form_data['field'] ) . '</td></tr>';
				}
				if ( $form_data['project_type'] !== '' ) {
					$message .= '<tr><th align="right">نوع سفارش</th><td>' . esc_html( $form_data['project_type'] ) . '</td></tr>';
				}
				if ( $form_data['deadline'] !== '' ) {
					$message .= '<tr><th align="right">مهلت تحویل</th><td>' . esc_html( $form_data['deadline'] ) . '</td></tr>';
				}
				if ( $form_data['contact_way'] !== '' ) {
					$message .= '<tr><th align="right">نحوه ترجیحی تماس</th><td>' . esc_html( $form_data['contact_way'] ) . '</td></tr>';
				}
				if ( $form_data['description'] !== '' ) {
					$message .= '<tr><th align="right">شرح کامل پروژه</th><td>' . wp_kses_post( nl2br( $form_data['description'] ) ) . '</td></tr>';
				}

				$message .= '</table>';
				$message .= '<p style="margin-top:16px;font-size:12px;color:#6b7280;">';
				$message .= 'این پیام به صورت خودکار از فرم ثبت سفارش وب‌سایت ارسال شده است.';
				$message .= '</p>';
				$message .= '</body></html>';

				$headers   = array();
				$from_name = $site_name . ' | فرم ثبت سفارش';

				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				$headers[] = 'From: ' . $from_name . ' <info@teznevisan3.com>';

				if ( $form_data['email'] !== '' ) {
					$headers[] = 'Reply-To: ' . $form_data['full_name'] . ' <' . $form_data['email'] . '>';
				}

				$mail_sent = wp_mail( $recipients, $subject, $message, $headers );

				if ( $mail_sent ) {
					$success   = true;
					$form_data = array();
				} else {
					$errors[] = 'در ارسال ایمیل مشکلی پیش آمد. لطفاً بعداً دوباره تلاش کنید یا از طریق تماس تلفنی با ما در ارتباط باشید.';
				}
			}
		}
	}

	ob_start();
	?>
	<style>
		.tez-inquiry-page {
			padding: 2.5rem 0 3rem;
			background: var(--tez-bg-secondary);
		}
		.tez-inquiry-layout {
			display: grid;
			grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
			gap: 2rem;
			align-items: flex-start;
		}
		@media (max-width: 991px) {
			.tez-inquiry-layout {
				grid-template-columns: 1fr;
			}
		}
		.tez-inquiry-card {
			background: var(--tez-card-bg);
			border: 1px solid var(--tez-card-border);
			border-radius: var(--tez-radius-xl);
			box-shadow: var(--tez-shadow-md);
			padding: 1.75rem 1.5rem;
		}
		@media (min-width: 768px) {
			.tez-inquiry-card {
				padding: 2rem 2rem;
			}
		}
		.tez-inquiry-title {
			font-size: var(--tez-text-3xl);
			margin-bottom: 0.75rem;
		}
		.tez-inquiry-subtitle {
			color: var(--tez-text-muted);
			margin-bottom: 1.5rem;
		}
		.tez-inquiry-badges {
			display: flex;
			flex-wrap: wrap;
			gap: 0.5rem;
			margin-bottom: 1.5rem;
		}
		.tez-inquiry-badge {
			font-size: var(--tez-text-xs);
			padding: 0.25rem 0.6rem;
			border-radius: var(--tez-radius-full);
			background: var(--tez-bg-tertiary);
			color: var(--tez-text-muted);
		}
		.tez-inquiry-meta {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1rem;
			margin-top: 1.5rem;
			font-size: var(--tez-text-sm);
		}
		@media (max-width: 575px) {
			.tez-inquiry-meta {
				grid-template-columns: 1fr;
			}
		}
		.tez-inquiry-meta-item {
			display: flex;
			align-items: flex-start;
			gap: 0.5rem;
			color: var(--tez-text-secondary);
		}
		.tez-inquiry-meta-item i {
			color: var(--tez-primary);
			margin-top: 0.1rem;
		}
		.tez-inquiry-contact-cta {
			margin-top: 1.75rem;
			padding-top: 1.5rem;
			border-top: 1px dashed var(--tez-border);
			display: flex;
			flex-wrap: wrap;
			gap: 0.75rem;
			align-items: center;
		}
		.tez-inquiry-contact-cta p {
			margin: 0;
			font-size: var(--tez-text-sm);
			color: var(--tez-text-muted);
		}
		.tez-inquiry-contact-actions {
			display: flex;
			flex-wrap: wrap;
			gap: 0.5rem;
		}
		.tez-inquiry-form-grid {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1rem 1.25rem;
		}
		@media (max-width: 575px) {
			.tez-inquiry-form-grid {
				grid-template-columns: 1fr;
			}
		}
		.tez-inquiry-form-group {
			display: flex;
			flex-direction: column;
			gap: 0.35rem;
		}
		.tez-inquiry-label {
			font-size: var(--tez-text-sm);
			font-weight: 600;
			color: var(--tez-text-secondary);
			display: flex;
			align-items: center;
			gap: 0.35rem;
		}
		.tez-inquiry-label span.required {
			color: var(--tez-danger);
			font-size: 0.9em;
		}
		.tez-inquiry-hint {
			font-size: var(--tez-text-xs);
			color: var(--tez-text-muted);
		}
		.tez-inquiry-input,
		.tez-inquiry-select,
		.tez-inquiry-textarea {
			width: 100%;
			border-radius: var(--tez-radius-md);
			border: 1px solid var(--tez-input-border);
			background: var(--tez-input-bg);
			color: var(--tez-text);
			padding: 0.6rem 0.75rem;
			font-size: var(--tez-text-sm);
			font-family: var(--tez-font);
			transition:
				border-color var(--tez-duration-fast) var(--tez-ease-default),
				box-shadow var(--tez-duration-fast) var(--tez-ease-default),
				background-color var(--tez-duration-fast) var(--tez-ease-default);
		}
		.tez-inquiry-input:focus,
		.tez-inquiry-select:focus,
		.tez-inquiry-textarea:focus {
			outline: none;
			border-color: var(--tez-input-focus);
			box-shadow: var(--tez-focus-ring);
		}
		.tez-inquiry-textarea {
			min-height: 140px;
			resize: vertical;
		}
		.tez-inquiry-input::placeholder,
		.tez-inquiry-textarea::placeholder {
			color: var(--tez-input-placeholder);
		}
		.tez-inquiry-footer {
			margin-top: 1.5rem;
			display: flex;
			flex-direction: column;
			gap: 0.75rem;
		}
		@media (min-width: 640px) {
			.tez-inquiry-footer {
				flex-direction: row;
				align-items: center;
				justify-content: space-between;
			}
		}
		.tez-inquiry-privacy {
			font-size: var(--tez-text-xs);
			color: var(--tez-text-muted);
		}
		.tez-inquiry-alert {
			border-radius: var(--tez-radius-md);
			padding: 0.75rem 0.9rem;
			font-size: var(--tez-text-sm);
			margin-bottom: 1rem;
		}
		.tez-inquiry-alert-success {
			background: #ecfdf3;
			border: 1px solid #22c55e;
			color: #166534;
		}
		.tez-inquiry-alert-error {
			background: #fef2f2;
			border: 1px solid #ef4444;
			color: #b91c1c;
		}
		.tez-inquiry-faq {
			margin-top: 2.5rem;
		}
		.tez-inquiry-faq-header {
			margin-bottom: 1.5rem;
		}
		.tez-inquiry-faq-header h2 {
			margin-bottom: 0.5rem;
		}
		.tez-inquiry-faq-header p {
			margin: 0;
			color: var(--tez-text-muted);
		}
		.tez-inquiry-faq-list {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 1.25rem;
		}
		@media (max-width: 767px) {
			.tez-inquiry-faq-list {
				grid-template-columns: 1fr;
			}
		}
		.tez-inquiry-faq-item {
			border-radius: var(--tez-radius-lg);
			border: 1px solid var(--tez-border);
			background: var(--tez-card-bg);
			padding: 1rem 1rem;
			box-shadow: var(--tez-shadow-xs);
		}
		@media (min-width: 768px) {
			.tez-inquiry-faq-item {
				padding: 1.25rem 1.25rem;
			}
		}
		.tez-inquiry-faq-question {
			font-weight: 700;
			margin-bottom: 0.35rem;
			display: flex;
			align-items: flex-start;
			gap: 0.4rem;
		}
		.tez-inquiry-faq-question i {
			color: var(--tez-primary);
			margin-top: 0.15rem;
		}
		.tez-inquiry-faq-answer {
			font-size: var(--tez-text-sm);
			color: var(--tez-text-secondary);
		}
		.tez-inquiry-faq-answer ul {
			margin: 0.5rem 1.25rem 0 0;
			padding: 0;
			list-style: disc;
		}
		.tez-inquiry-faq-answer li {
			margin-bottom: 0.25rem;
		}
		.tez-inquiry-faq-note {
			margin-top: 1.5rem;
			font-size: var(--tez-text-sm);
			color: var(--tez-text-muted);
		}
	</style>

	<section class="tez-inquiry-page">
		<div class="tez-container">
			<div class="tez-inquiry-layout">
				<div class="tez-inquiry-card">
					<h1 class="tez-inquiry-title">فرم ثبت سفارش انجام پروژه و امور پژوهشی</h1>
					<p class="tez-inquiry-subtitle">
						جهت ثبت سفارش انجام پروژه و امور پژوهشی خود تنها کافیست فرم زیر را تکمیل نمایید تا کارشناسان
						مربوطه در اسرع وقت با شما تماس حاصل فرمایند. هر چه اطلاعات دقیق‌تری وارد کنید، برآورد هزینه و زمان
						با دقت بیشتری انجام خواهد شد.
					</p>

					<div class="tez-inquiry-badges">
						<span class="tez-inquiry-badge">پاسخگویی سریع در ساعات کاری</span>
						<span class="tez-inquiry-badge">مشاوره رایگان اولیه</span>
						<span class="tez-inquiry-badge">حفظ کامل محرمانگی اطلاعات</span>
						<span class="tez-inquiry-badge">پشتیبانی تا تحویل نهایی</span>
					</div>

					<div class="tez-inquiry-meta">
						<div class="tez-inquiry-meta-item">
							<i class="fa-solid fa-clock"></i>
							<div>
								<strong>زمان تماس پس از ثبت فرم</strong>
								<p>
									در روزهای کاری معمولاً بین
									<strong>۱۰ دقیقه تا ۱ ساعت</strong> با شما تماس گرفته می‌شود.
									در روزهای تعطیل نیز حداکثر تا <strong>۵ ساعت</strong> با شما در ارتباط خواهیم بود.
								</p>
							</div>
						</div>
						<div class="tez-inquiry-meta-item">
							<i class="fa-solid fa-shield-halved"></i>
							<div>
								<strong>محرمانگی اطلاعات شما</strong>
								<p>
									نام، اطلاعات تماس و جزئیات پروژه شما نزد موسسه تزنویسان محفوظ بوده
									و صرفاً جهت هماهنگی و ارائه مشاوره استفاده می‌شود.
								</p>
							</div>
						</div>
					</div>

					<div class="tez-inquiry-contact-cta">
						<p>
							در صورت تمایل می‌توانید به‌جای پر کردن فرم، از طریق دکمه‌های زیر نیز مستقیماً با ما در ارتباط باشید.
						</p>
						<div class="tez-inquiry-contact-actions">
							<?php
							/** @var string $tez_phone Phone constant if defined. */
							$tez_phone = defined( 'TEZ_PHONE' ) ? TEZ_PHONE : '';
							if ( $tez_phone ) :
								?>
								<a href="tel:<?php echo esc_attr( $tez_phone ); ?>" class="tez-btn tez-btn-primary">
									<i class="fa-solid fa-phone"></i>
									تماس تلفنی مستقیم
								</a>
							<?php endif; ?>
							<?php if ( defined( 'TEZ_WHATSAPP' ) ) : ?>
								<a href="https://wa.me/<?php echo esc_attr( TEZ_WHATSAPP ); ?>" target="_blank" rel="noopener noreferrer" class="tez-btn tez-btn-secondary">
									<i class="fa-brands fa-whatsapp"></i>
									ارتباط از طریق واتساپ
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="tez-inquiry-card">
					<?php if ( $success ) : ?>
						<div class="tez-inquiry-alert tez-inquiry-alert-success">
							<strong>درخواست شما با موفقیت ثبت شد.</strong>
							<br />
							همکاران ما در اولین فرصت در ساعات کاری با شما تماس خواهند گرفت. لطفاً تا آن زمان پاسخگوی
							شماره تماسی که وارد کرده‌اید باشید.
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $errors ) ) : ?>
						<div class="tez-inquiry-alert tez-inquiry-alert-error">
							<?php foreach ( $errors as $error_message ) : ?>
								<div><?php echo esc_html( $error_message ); ?></div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<form method="post" class="tez-inquiry-form" novalidate>
						<?php wp_nonce_field( 'tez_inquiry_submit', 'tez_inquiry_nonce' ); ?>

						<div class="tez-inquiry-form-grid">
							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-full-name">
									نام و نام خانوادگی
									<span class="required">*</span>
								</label>
								<input
									id="tez-full-name"
									name="full_name"
									type="text"
									class="tez-inquiry-input"
									placeholder="مثلاً: علی رضایی"
									value="<?php echo isset( $form_data['full_name'] ) ? esc_attr( $form_data['full_name'] ) : ''; ?>"
									required
								/>
							</div>

							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-phone">
									شماره تماس (همراه)
									<span class="required">*</span>
								</label>
								<input
									id="tez-phone"
									name="phone"
									type="tel"
									class="tez-inquiry-input"
									placeholder="مثلاً: ۰۹۱۲..."
									value="<?php echo isset( $form_data['phone'] ) ? esc_attr( $form_data['phone'] ) : ''; ?>"
									required
								/>
								<p class="tez-inquiry-hint">
									لطفاً شماره‌ای را وارد کنید که در واتساپ یا تلگرام نیز فعال باشد.
								</p>
							</div>

							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-email">
									ایمیل (اختیاری)
								</label>
								<input
									id="tez-email"
									name="email"
									type="email"
									class="tez-inquiry-input"
									placeholder="در صورت تمایل، ایمیل خود را وارد کنید"
									value="<?php echo isset( $form_data['email'] ) ? esc_attr( $form_data['email'] ) : ''; ?>"
								/>
							</div>

							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-education">
									مقطع تحصیلی
								</label>
								<select
									id="tez-education"
									name="education"
									class="tez-inquiry-select"
								>
									<?php
									$education = isset( $form_data['education'] ) ? $form_data['education'] : '';
									?>
									<option value="">انتخاب کنید</option>
									<option value="کاردانی" <?php selected( $education, 'کاردانی' ); ?>>کاردانی</option>
									<option value="کارشناسی" <?php selected( $education, 'کارشناسی' ); ?>>کارشناسی</option>
									<option value="کارشناسی ارشد" <?php selected( $education, 'کارشناسی ارشد' ); ?>>کارشناسی ارشد</option>
									<option value="دکتری" <?php selected( $education, 'دکتری' ); ?>>دکتری</option>
									<option value="سایر" <?php selected( $education, 'سایر' ); ?>>سایر</option>
								</select>
							</div>

							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-field">
									رشته / گرایش
								</label>
								<input
									id="tez-field"
									name="field"
									type="text"
									class="tez-inquiry-input"
									placeholder="مثلاً: مدیریت بازرگانی – گرایش بازاریابی"
									value="<?php echo isset( $form_data['field'] ) ? esc_attr( $form_data['field'] ) : ''; ?>"
								/>
							</div>

							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-project-type">
									نوع سفارش
								</label>
								<select
									id="tez-project-type"
									name="project_type"
									class="tez-inquiry-select"
								>
									<?php
									$project_type = isset( $form_data['project_type'] ) ? $form_data['project_type'] : '';
									?>
									<option value="">انتخاب کنید</option>
									<option value="پایان‌نامه" <?php selected( $project_type, 'پایان‌نامه' ); ?>>پایان‌نامه</option>
									<option value="پروپوزال" <?php selected( $project_type, 'پروپوزال' ); ?>>پروپوزال</option>
									<option value="مقاله علمی / ISI" <?php selected( $project_type, 'مقاله علمی / ISI' ); ?>>مقاله علمی / ISI</option>
									<option value="تحقیق / پروژه درسی" <?php selected( $project_type, 'تحقیق / پروژه درسی' ); ?>>تحقیق / پروژه درسی</option>
									<option value="ترجمه" <?php selected( $project_type, 'ترجمه' ); ?>>ترجمه</option>
									<option value="پاورپوینت / ارائه" <?php selected( $project_type, 'پاورپوینت / ارائه' ); ?>>پاورپوینت / ارائه</option>
									<option value="آموزش و مشاوره" <?php selected( $project_type, 'آموزش و مشاوره' ); ?>>آموزش و مشاوره</option>
									<option value="سایر" <?php selected( $project_type, 'سایر' ); ?>>سایر</option>
								</select>
							</div>

							<div class="tez-inquiry-form-group">
								<label class="tez-inquiry-label" for="tez-deadline">
									مهلت تحویل مورد انتظار
								</label>
								<input
									id="tez-deadline"
									name="deadline"
									type="text"
									class="tez-inquiry-input"
									placeholder="مثلاً: حداکثر تا پایان شهریور"
									value="<?php echo isset( $form_data['deadline'] ) ? esc_attr( $form_data['deadline'] ) : ''; ?>"
								/>
							</div>

							<div class="tez-inquiry-form-group" style="grid-column: 1 / -1;">
								<label class="tez-inquiry-label" for="tez-contact-way">
									نحوه ترجیحی تماس
								</label>
								<select
									id="tez-contact-way"
									name="contact_way"
									class="tez-inquiry-select"
								>
									<?php
									$contact_way = isset( $form_data['contact_way'] ) ? $form_data['contact_way'] : '';
									?>
									<option value="">فرقی ندارد – هر روشی مناسب است</option>
									<option value="تماس تلفنی" <?php selected( $contact_way, 'تماس تلفنی' ); ?>>تماس تلفنی</option>
									<option value="واتساپ" <?php selected( $contact_way, 'واتساپ' ); ?>>واتساپ</option>
									<option value="تلگرام" <?php selected( $contact_way, 'تلگرام' ); ?>>تلگرام</option>
									<option value="ایمیل" <?php selected( $contact_way, 'ایمیل' ); ?>>ایمیل</option>
								</select>
								<p class="tez-inquiry-hint">
									اگر تمایل دارید فقط از طریق شبکه‌های اجتماعی با شما در ارتباط باشیم، نام شبکه اجتماعی و آیدی خود را نیز در قسمت
									«شرح پروژه» بنویسید.
								</p>
							</div>

							<div class="tez-inquiry-form-group" style="grid-column: 1 / -1;">
								<label class="tez-inquiry-label" for="tez-description">
									شرح کامل پروژه / سفارش
									<span class="required">*</span>
								</label>
								<textarea
									id="tez-description"
									name="description"
									class="tez-inquiry-textarea"
									placeholder="نرم‌افزار یا روش موردنظر (SPSS، PLS، MATLAB و ...)، نوع خدمات موردنیاز (نگارش، ویرایش، پاورپوینت، آموزش و ...)، توضیح مختصر در مورد موضوع، سوالات خود و هر نکته‌ای که احساس می‌کنید مهم است را در این بخش بنویسید."
									required
								><?php echo isset( $form_data['description'] ) ? esc_textarea( $form_data['description'] ) : ''; ?></textarea>
								<p class="tez-inquiry-hint">
									هر چه توضیحات شما کامل‌تر باشد، مشاوره تخصصی‌تری دریافت خواهید کرد و زمان برآورد هزینه و مدت انجام پروژه کوتاه‌تر می‌شود.
								</p>
							</div>
						</div>

						<div class="tez-inquiry-footer">
							<button
								type="submit"
								name="tez_inquiry_submit"
								value="1"
								class="tez-btn tez-btn-primary"
							>
								<i class="fa-solid fa-paper-plane"></i>
								ثبت نهایی سفارش
							</button>
							<p class="tez-inquiry-privacy">
								اطلاعات واردشده در این فرم فقط توسط کارشناسان موسسه تزنویسان بررسی شده و تحت هیچ شرایطی در اختیار اشخاص ثالث قرار نخواهد گرفت.
							</p>
						</div>
					</form>
				</div>
			</div>

			<div class="tez-inquiry-faq">
				<div class="tez-inquiry-faq-header">
					<h2>سوالات متداول ثبت سفارش</h2>
					<p>
						در قسمت زیر، برخی از سوالاتی که ممکن است برای شما نیز پیش بیاید را پاسخ داده‌ایم.
						در صورت وجود هرگونه سؤال دیگر، از طریق همین فرم یا راه‌های ارتباطی دیگر با ما در میان بگذارید.
					</p>
				</div>

				<div class="tez-inquiry-faq-list">
					<div class="tez-inquiry-faq-item">
						<div class="tez-inquiry-faq-question">
							<i class="fa-solid fa-question-circle"></i>
							<span>بعد از چه مدت با من تماس گرفته می‌شود؟</span>
						</div>
						<div class="tez-inquiry-faq-answer">
							در روزهای کاری معمولاً از <strong>۱۰ دقیقه تا ۱ ساعت</strong> بعد از تکمیل فرم با شما تماس گرفته
							می‌شود. در روزهای تعطیل نیز حداکثر طی <strong>۵ ساعت</strong> این کار صورت می‌پذیرد.
						</div>
					</div>

					<div class="tez-inquiry-faq-item">
						<div class="tez-inquiry-faq-question">
							<i class="fa-solid fa-file-lines"></i>
							<span>داخل قسمت «شرح پروژه» چه چیزی باید بنویسم؟</span>
						</div>
						<div class="tez-inquiry-faq-answer">
							در این بخش می‌توانید:
							<ul>
								<li>نام نرم‌افزارهای موردنیاز برای انجام پروژه (مانند SPSS، PLS، R، MATLAB و ...)،</li>
								<li>نوع خدمات موردنیاز (نگارش، ویرایش، تحلیل آماری، پاورپوینت، آموزش و ...)،</li>
								<li>حجم تقریبی کار (تعداد صفحات، فصل‌ها، تعداد فرضیه‌ها و ...)،</li>
								<li>ددلاین یا زمان‌بندی مدنظر،</li>
								<li>و هرگونه سؤال یا ابهامی که درباره پروژه دارید</li>
							</ul>
							را با جزئیات ذکر کنید تا هنگام تماس، پاسخ دقیق‌تری دریافت نمایید.
						</div>
					</div>

					<div class="tez-inquiry-faq-item">
						<div class="tez-inquiry-faq-question">
							<i class="fa-solid fa-user-shield"></i>
							<span>چرا به نام و نام خانوادگی من نیاز دارید؟</span>
						</div>
						<div class="tez-inquiry-faq-answer">
							صرفاً جهت خطاب کردن محترمانه شما و ثبت دقیق سفارش در سیستم تزنویسان به نام خودتان.
							نام و اطلاعات شما نزد موسسه تزنویسان محفوظ بوده و نیازی نیست نگران محرمانگی اطلاعات خود باشید.
						</div>
					</div>

					<div class="tez-inquiry-faq-item">
						<div class="tez-inquiry-faq-question">
							<i class="fa-solid fa-comments"></i>
							<span>آیا امکانش هست به‌جای تماس تلفنی در شبکه‌های اجتماعی در ارتباط باشیم؟</span>
						</div>
						<div class="tez-inquiry-faq-answer">
							بله. شما می‌توانید در داخل باکس «شرح پروژه»، نام شبکه اجتماعی موردنظر خود
							(واتساپ، تلگرام و ...) به‌همراه آیدی یا شماره مربوطه را بنویسید تا هماهنگی‌ها
							از همان طریق انجام شود. همچنین می‌توانید از دکمه‌های تماس و واتساپ موجود در صفحه برای ارتباط مستقیم استفاده کنید.
						</div>
					</div>

					<div class="tez-inquiry-faq-item">
						<div class="tez-inquiry-faq-question">
							<i class="fa-solid fa-scale-balanced"></i>
							<span>آیا قبل از شروع کار، برآورد هزینه و زمان انجام پروژه به من اعلام می‌شود؟</span>
						</div>
						<div class="tez-inquiry-faq-answer">
							بله، پس از بررسی اولیه توضیحات شما، کارشناس مربوطه با شما تماس گرفته و
							ضمن ارائه مشاوره، <strong>هزینه تقریبی</strong> و <strong>مدت زمان انجام</strong> پروژه را به‌صورت شفاف اعلام می‌کند.
							شروع همکاری تنها پس از تأیید نهایی شما انجام خواهد شد.
						</div>
					</div>

					<div class="tez-inquiry-faq-item">
						<div class="tez-inquiry-faq-question">
							<i class="fa-solid fa-lock"></i>
							<span>آیا امکان پیگیری و پشتیبانی بعد از تحویل وجود دارد؟</span>
						</div>
						<div class="tez-inquiry-faq-answer">
							بله، تیم تزنویسان تا زمان تأیید نهایی پروژه توسط شما و اساتید راهنما،
							در کنار شما خواهد بود. در صورت نیاز به اصلاحات، هماهنگی جلسات دفاع، آماده‌سازی پاورپوینت و موارد مشابه، می‌توانید روی همراهی ما حساب کنید.
						</div>
					</div>
				</div>

				<p class="tez-inquiry-faq-note">
					اگر سؤال دیگری در ذهن شماست که در این بخش پاسخ داده نشده است،
					کافیست آن را در قسمت «شرح پروژه» بنویسید تا هنگام تماس، به‌طور کامل راهنمایی شوید.
				</p>
			</div>
		</div>
	</section>
	<?php
	$html = ob_get_clean();
	return $html;
}
add_filter( 'the_content', 'tez_render_inquiry_page_content', 999 );