<?php
/**
 * Template Name: Tez - Services Landing
 * Description: Services page with quick inquiry form at top, collapsible service sections.
 *
 * @package JannahChild
 * @version 3.0.0
 */
get_header();

$phone = defined('TEZ_PHONE') ? TEZ_PHONE : '09331663849';
$whatsapp = defined('TEZ_WHATSAPP') ? TEZ_WHATSAPP : '09331663849';
$telegram = defined('TEZ_TELEGRAM') ? TEZ_TELEGRAM : 'Thesissupport';
?>

<!-- Hero -->
<section class="tez-page-hero">
    <div class="tez-hero-bg"><div class="tez-hero-pattern"></div></div>
    <div class="tez-hero-content tez-container">
        <h1><i class="fa-solid fa-graduation-cap"></i> \u062e\u062f\u0645\u0627\u062a \u062a\u062e\u0635\u0635\u06cc \u062a\u0632 \u0646\u0648\u06cc\u0633\u0627\u0646</h1>
        <p>\u0627\u0646\u062c\u0627\u0645 \u067e\u0631\u0648\u0698\u0647\u200c\u0647\u0627\u06cc \u062f\u0627\u0646\u0634\u062c\u0648\u06cc\u06cc \u062f\u0631 \u062a\u0645\u0627\u0645\u06cc \u0631\u0634\u062a\u0647\u200c\u0647\u0627 \u0648 \u0645\u0642\u0627\u0637\u0639 \u062a\u062d\u0635\u06cc\u0644\u06cc \u0628\u0627 \u0628\u0627\u0644\u0627\u062a\u0631\u06cc\u0646 \u06a9\u06cc\u0641\u06cc\u062a</p>
    </div>
</section>

<!-- Quick Inquiry Form -->
<div class="tez-container">
    <div class="tez-quick-inquiry scroll-animate">
        <div class="tez-quick-inquiry-header">
            <h3><i class="fa-solid fa-bolt"></i> \u062f\u0631\u062e\u0648\u0627\u0633\u062a \u0633\u0631\u06cc\u0639 \u0645\u0634\u0627\u0648\u0631\u0647</h3>
            <p>\u0627\u0637\u0644\u0627\u0639\u0627\u062a \u062e\u0648\u062f \u0631\u0627 \u0648\u0627\u0631\u062f \u06a9\u0646\u06cc\u062f\u060c \u06a9\u0627\u0631\u0634\u0646\u0627\u0633\u0627\u0646 \u0645\u0627 \u062f\u0631 \u0627\u0633\u0631\u0639 \u0648\u0642\u062a \u0628\u0627 \u0634\u0645\u0627 \u062a\u0645\u0627\u0633 \u0645\u06cc\u200c\u06af\u06cc\u0631\u0646\u062f</p>
        </div>
        <form class="tez-quick-inquiry-form" id="tez-quick-inquiry-form" method="post">
            <?php wp_nonce_field('tez_quick_inquiry', 'tez_inquiry_nonce'); ?>
            <input type="text" name="tez_name" class="tez-form-control" placeholder="\u0646\u0627\u0645 \u0648 \u0646\u0627\u0645 \u062e\u0627\u0646\u0648\u0627\u062f\u06af\u06cc" required>
            <input type="tel" name="tez_phone" class="tez-form-control" placeholder="\u0634\u0645\u0627\u0631\u0647 \u0645\u0648\u0628\u0627\u06cc\u0644" required pattern="[0-9]{11}" dir="ltr">
            <input type="text" name="tez_major" class="tez-form-control" placeholder="\u0631\u0634\u062a\u0647 \u062a\u062d\u0635\u06cc\u0644\u06cc" required>
            <button type="submit" class="tez-btn tez-btn-primary tez-btn-submit">
                <i class="fa-solid fa-paper-plane"></i> \u0627\u0631\u0633\u0627\u0644
            </button>
        </form>
        <div class="tez-quick-inquiry-badge">
            <span><i class="fa-solid fa-shield-check"></i> \u0645\u062d\u0631\u0645\u0627\u0646\u0647</span>
            <span><i class="fa-solid fa-clock"></i> \u067e\u0627\u0633\u062e \u062f\u0631 \u06a9\u0645\u062a\u0631 \u0627\u0632 \u06f3\u06f0 \u062f\u0642\u06cc\u0642\u0647</span>
            <span><i class="fa-solid fa-phone"></i> \u0645\u0634\u0627\u0648\u0631\u0647 \u0631\u0627\u06cc\u06af\u0627\u0646</span>
        </div>
    </div>
</div>

<!-- Services Accordion -->
<section class="tez-section">
    <div class="tez-container">
        <div class="tez-section-header scroll-animate">
            <h2>\u062e\u062f\u0645\u0627\u062a \u0645\u0627</h2>
            <p>\u0631\u0648\u06cc \u0647\u0631 \u062e\u062f\u0645\u062a \u06a9\u0644\u06cc\u06a9 \u06a9\u0646\u06cc\u062f \u062a\u0627 \u062c\u0632\u0626\u06cc\u0627\u062a \u0628\u06cc\u0634\u062a\u0631\u06cc \u0628\u0628\u06cc\u0646\u06cc\u062f</p>
        </div>

        <div class="tez-services-list" id="tez-services-list">

            <!-- Service 1 -->
            <div class="tez-service-accordion scroll-animate">
                <button type="button" class="tez-service-accordion-header" aria-expanded="false">
                    <div class="tez-service-accordion-icon"><i class="fa-solid fa-file-lines"></i></div>
                    <div class="tez-service-accordion-title">
                        <h3>\u0627\u0646\u062c\u0627\u0645 \u067e\u0631\u0648\u0698\u0647\u200c\u0647\u0627\u06cc \u062f\u0627\u0646\u0634\u062c\u0648\u06cc\u06cc</h3>
                        <p>\u067e\u0627\u06cc\u0627\u0646\u200c\u0646\u0627\u0645\u0647\u060c \u0631\u0633\u0627\u0644\u0647\u060c \u062a\u062d\u0642\u06cc\u0642 \u0648 \u067e\u0631\u0648\u0698\u0647\u200c\u0647\u0627\u06cc \u062f\u0631\u0633\u06cc</p>
                    </div>
                    <div class="tez-service-accordion-arrow"><i class="fa-solid fa-chevron-down"></i></div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>\u062a\u06cc\u0645 \u0645\u062a\u062e\u0635\u0635 \u062a\u0632 \u0646\u0648\u06cc\u0633\u0627\u0646 \u0628\u0627 \u0628\u06cc\u0634 \u0627\u0632 \u06f4\u06f5\u06f0 \u0645\u062d\u0642\u0642 \u062f\u0631 \u062a\u0645\u0627\u0645\u06cc \u0631\u0634\u062a\u0647\u200c\u0647\u0627\u060c \u0622\u0645\u0627\u062f\u0647 \u0627\u0646\u062c\u0627\u0645 \u067e\u0631\u0648\u0698\u0647\u200c\u0647\u0627\u06cc \u062f\u0627\u0646\u0634\u062c\u0648\u06cc\u06cc \u0634\u0645\u0627 \u0628\u0627 \u0628\u0627\u0644\u0627\u062a\u0631\u06cc\u0646 \u06a9\u06cc\u0641\u06cc\u062a \u0627\u0633\u062a.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u067e\u0627\u06cc\u0627\u0646\u200c\u0646\u0627\u0645\u0647 \u06a9\u0627\u0631\u0634\u0646\u0627\u0633\u06cc \u0648 \u0627\u0631\u0634\u062f</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0631\u0633\u0627\u0644\u0647 \u062f\u06a9\u062a\u0631\u06cc</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u067e\u0631\u0648\u0698\u0647\u200c\u0647\u0627\u06cc \u062f\u0631\u0633\u06cc \u0648 \u062a\u062d\u0642\u06cc\u0642\u06cc</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u062a\u0645\u0627\u0645\u06cc \u0631\u0634\u062a\u0647\u200c\u0647\u0627 \u0648 \u0645\u0642\u0627\u0637\u0639</span></div>
                        </div>
                        <div class="tez-service-accordion-footer">
                            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-primary"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-btn tez-btn-secondary"><i class="fa-solid fa-phone"></i> \u0645\u0634\u0627\u0648\u0631\u0647 \u0631\u0627\u06cc\u06af\u0627\u0646</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="tez-service-accordion scroll-animate">
                <button type="button" class="tez-service-accordion-header" aria-expanded="false">
                    <div class="tez-service-accordion-icon"><i class="fa-solid fa-lightbulb"></i></div>
                    <div class="tez-service-accordion-title">
                        <h3>\u0627\u0646\u062c\u0627\u0645 \u067e\u0631\u0648\u067e\u0648\u0632\u0627\u0644</h3>
                        <p>\u0646\u06af\u0627\u0631\u0634 \u067e\u0631\u0648\u067e\u0648\u0632\u0627\u0644 \u062a\u062d\u0642\u06cc\u0642\u0627\u062a\u06cc \u0628\u0631\u0627\u06cc \u062a\u0645\u0627\u0645\u06cc \u0645\u0642\u0627\u0637\u0639</p>
                    </div>
                    <div class="tez-service-accordion-arrow"><i class="fa-solid fa-chevron-down"></i></div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>\u067e\u0631\u0648\u067e\u0648\u0632\u0627\u0644 \u0627\u0648\u0644\u06cc\u0646 \u0642\u062f\u0645 \u0645\u0647\u0645 \u062f\u0631 \u0627\u0646\u062c\u0627\u0645 \u062a\u062d\u0642\u06cc\u0642\u0627\u062a \u0627\u0633\u062a. \u0645\u0627 \u0628\u0627 \u062a\u062c\u0631\u0628\u0647 \u0648\u0633\u06cc\u0639 \u062f\u0631 \u0646\u06af\u0627\u0631\u0634 \u067e\u0631\u0648\u067e\u0648\u0632\u0627\u0644\u200c\u0647\u0627\u06cc \u0645\u0648\u0641\u0642\u060c \u0622\u0645\u0627\u062f\u0647 \u06a9\u0645\u06a9 \u0628\u0647 \u0634\u0645\u0627 \u0647\u0633\u062a\u06cc\u0645.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0627\u0646\u062a\u062e\u0627\u0628 \u0645\u0648\u0636\u0648\u0639 \u0645\u0646\u0627\u0633\u0628</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0628\u0631\u0631\u0633\u06cc \u0627\u062f\u0628\u06cc\u0627\u062a \u062a\u062d\u0642\u06cc\u0642</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0637\u0631\u0627\u062d\u06cc \u0631\u0648\u0634 \u062a\u062d\u0642\u06cc\u0642</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u062a\u0636\u0645\u06cc\u0646 \u062a\u0635\u0648\u06cc\u0628 \u0627\u0633\u062a\u0627\u062f</span></div>
                        </div>
                        <div class="tez-service-accordion-footer">
                            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-primary"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="tez-service-accordion scroll-animate">
                <button type="button" class="tez-service-accordion-header" aria-expanded="false">
                    <div class="tez-service-accordion-icon"><i class="fa-solid fa-newspaper"></i></div>
                    <div class="tez-service-accordion-title">
                        <h3>\u0627\u0646\u062c\u0627\u0645 \u0645\u0642\u0627\u0644\u0647</h3>
                        <p>\u0646\u06af\u0627\u0631\u0634 \u0645\u0642\u0627\u0644\u0627\u062a \u0639\u0644\u0645\u06cc-\u067e\u0698\u0648\u0647\u0634\u06cc \u0648 ISI</p>
                    </div>
                    <div class="tez-service-accordion-arrow"><i class="fa-solid fa-chevron-down"></i></div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>\u0646\u06af\u0627\u0631\u0634 \u0645\u0642\u0627\u0644\u0627\u062a \u0639\u0644\u0645\u06cc \u0628\u0631\u0627\u06cc \u0645\u062c\u0644\u0627\u062a \u062f\u0627\u062e\u0644\u06cc \u0648 \u0628\u06cc\u0646\u200c\u0627\u0644\u0645\u0644\u0644\u06cc\u060c \u0647\u0645\u0627\u06cc\u0634\u200c\u0647\u0627 \u0648 \u06a9\u0646\u0641\u0631\u0627\u0646\u0633\u200c\u0647\u0627.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0645\u0642\u0627\u0644\u0627\u062a ISI \u0648 Scopus</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0645\u0642\u0627\u0644\u0627\u062a \u0639\u0644\u0645\u06cc-\u067e\u0698\u0648\u0647\u0634\u06cc</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0645\u0642\u0627\u0644\u0627\u062a \u0647\u0645\u0627\u06cc\u0634\u06cc</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0627\u0633\u062a\u062e\u0631\u0627\u062c \u0645\u0642\u0627\u0644\u0647 \u0627\u0632 \u067e\u0627\u06cc\u0627\u0646\u200c\u0646\u0627\u0645\u0647</span></div>
                        </div>
                        <div class="tez-service-accordion-footer">
                            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-primary"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="tez-service-accordion scroll-animate">
                <button type="button" class="tez-service-accordion-header" aria-expanded="false">
                    <div class="tez-service-accordion-icon"><i class="fa-solid fa-chart-bar"></i></div>
                    <div class="tez-service-accordion-title">
                        <h3>\u0627\u0646\u062c\u0627\u0645 \u062a\u062d\u0644\u06cc\u0644 \u0622\u0645\u0627\u0631\u06cc</h3>
                        <p>SPSS, AMOS, PLS, R, Eviews \u0648 \u0633\u0627\u06cc\u0631 \u0646\u0631\u0645\u200c\u0627\u0641\u0632\u0627\u0631\u0647\u0627</p>
                    </div>
                    <div class="tez-service-accordion-arrow"><i class="fa-solid fa-chevron-down"></i></div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>\u062a\u062d\u0644\u06cc\u0644 \u062f\u0627\u062f\u0647\u200c\u0647\u0627\u06cc \u0622\u0645\u0627\u0631\u06cc \u0628\u0627 \u062a\u0645\u0627\u0645\u06cc \u0646\u0631\u0645\u200c\u0627\u0641\u0632\u0627\u0631\u0647\u0627\u06cc \u062a\u062e\u0635\u0635\u06cc \u0628\u0647 \u0647\u0645\u0631\u0627\u0647 \u062a\u0641\u0633\u06cc\u0631 \u0646\u062a\u0627\u06cc\u062c.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>SPSS, AMOS, LISREL</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>SmartPLS, R, Python</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>Eviews, Stata, MATLAB</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u062a\u0641\u0633\u06cc\u0631 \u06a9\u0627\u0645\u0644 \u0646\u062a\u0627\u06cc\u062c</span></div>
                        </div>
                        <div class="tez-service-accordion-footer">
                            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-primary"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="tez-service-accordion scroll-animate">
                <button type="button" class="tez-service-accordion-header" aria-expanded="false">
                    <div class="tez-service-accordion-icon"><i class="fa-solid fa-laptop-code"></i></div>
                    <div class="tez-service-accordion-title">
                        <h3>\u0627\u0646\u062c\u0627\u0645 \u0634\u0628\u06cc\u0647\u200c\u0633\u0627\u0632\u06cc \u0646\u0631\u0645\u200c\u0627\u0641\u0632\u0627\u0631\u06cc</h3>
                        <p>MATLAB, Simulink, ANSYS, ABAQUS, COMSOL \u0648 \u0633\u0627\u06cc\u0631 \u0646\u0631\u0645\u200c\u0627\u0641\u0632\u0627\u0631\u0647\u0627</p>
                    </div>
                    <div class="tez-service-accordion-arrow"><i class="fa-solid fa-chevron-down"></i></div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>\u0634\u0628\u06cc\u0647\u200c\u0633\u0627\u0632\u06cc \u0648 \u0645\u062f\u0644\u200c\u0633\u0627\u0632\u06cc \u0628\u0627 \u0646\u0631\u0645\u200c\u0627\u0641\u0632\u0627\u0631\u0647\u0627\u06cc \u062a\u062e\u0635\u0635\u06cc \u0645\u0647\u0646\u062f\u0633\u06cc \u0648 \u0639\u0644\u0648\u0645 \u067e\u0627\u06cc\u0647.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>MATLAB / Simulink</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>ANSYS / ABAQUS / COMSOL</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0628\u0631\u0646\u0627\u0645\u0647\u200c\u0646\u0648\u06cc\u0633\u06cc Python / C++ / Java</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0647\u0648\u0634 \u0645\u0635\u0646\u0648\u0639\u06cc \u0648 \u06cc\u0627\u062f\u06af\u06cc\u0631\u06cc \u0645\u0627\u0634\u06cc\u0646</span></div>
                        </div>
                        <div class="tez-service-accordion-footer">
                            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-primary"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="tez-service-accordion scroll-animate">
                <button type="button" class="tez-service-accordion-header" aria-expanded="false">
                    <div class="tez-service-accordion-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="tez-service-accordion-title">
                        <h3>\u0627\u0646\u062c\u0627\u0645 \u0628\u06cc\u0632\u06cc\u0646\u0633 \u067e\u0644\u0646</h3>
                        <p>\u0637\u0631\u062d \u062a\u0648\u062c\u06cc\u0647\u06cc\u060c \u0628\u06cc\u0632\u06cc\u0646\u0633 \u067e\u0644\u0646 \u0648 \u0637\u0631\u062d \u06a9\u0633\u0628\u200c\u0648\u06a9\u0627\u0631</p>
                    </div>
                    <div class="tez-service-accordion-arrow"><i class="fa-solid fa-chevron-down"></i></div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>\u062a\u062f\u0648\u06cc\u0646 \u0637\u0631\u062d\u200c\u0647\u0627\u06cc \u062a\u0648\u062c\u06cc\u0647\u06cc \u0648 \u0628\u06cc\u0632\u06cc\u0646\u0633 \u067e\u0644\u0646 \u062d\u0631\u0641\u0647\u200c\u0627\u06cc \u0628\u0631\u0627\u06cc \u062c\u0630\u0628 \u0633\u0631\u0645\u0627\u06cc\u0647 \u0648 \u0627\u062e\u0630 \u0645\u062c\u0648\u0632.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0637\u0631\u062d \u062a\u0648\u062c\u06cc\u0647\u06cc \u0641\u0646\u06cc-\u0627\u0642\u062a\u0635\u0627\u062f\u06cc</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u0628\u06cc\u0632\u06cc\u0646\u0633 \u067e\u0644\u0646 \u0627\u0633\u062a\u0627\u0646\u062f\u0627\u0631\u062f</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u062a\u062d\u0644\u06cc\u0644 \u0628\u0627\u0632\u0627\u0631 \u0648 \u0631\u0642\u0628\u0627</span></div>
                            <div class="tez-service-feature-item"><i class="fa-solid fa-check-circle"></i><span>\u067e\u06cc\u0634\u200c\u0628\u06cc\u0646\u06cc \u0645\u0627\u0644\u06cc</span></div>
                        </div>
                        <div class="tez-service-accordion-footer">
                            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-primary"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Why Us -->
<section class="tez-section tez-section-alt">
    <div class="tez-container">
        <div class="tez-section-header scroll-animate">
            <h2>\u0686\u0631\u0627 \u062a\u0632 \u0646\u0648\u06cc\u0633\u0627\u0646\u061f</h2>
            <p>\u062f\u0644\u0627\u06cc\u0644\u06cc \u06a9\u0647 \u0645\u0627 \u0631\u0627 \u0627\u0632 \u0633\u0627\u06cc\u0631\u06cc\u0646 \u0645\u062a\u0645\u0627\u06cc\u0632 \u0645\u06cc\u200c\u06a9\u0646\u062f</p>
        </div>
        <div class="tez-advantages-grid">
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-users"></i></div>
                <h4>\u06f4\u06f5\u06f0+ \u0645\u062d\u0642\u0642 \u0645\u062a\u062e\u0635\u0635</h4>
                <p>\u062a\u06cc\u0645\u06cc \u0628\u0632\u0631\u06af \u0627\u0632 \u0645\u062d\u0642\u0642\u0627\u0646 \u0628\u0627 \u0645\u062f\u0631\u06a9 \u062f\u06a9\u062a\u0631\u06cc \u0648 \u06a9\u0627\u0631\u0634\u0646\u0627\u0633\u06cc \u0627\u0631\u0634\u062f</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-shield-check"></i></div>
                <h4>\u062a\u0636\u0645\u06cc\u0646 \u06a9\u06cc\u0641\u06cc\u062a</h4>
                <p>\u06af\u0627\u0631\u0627\u0646\u062a\u06cc \u06a9\u06cc\u0641\u06cc\u062a \u0648 \u0627\u0635\u0644\u0627\u062d\u0627\u062a \u0646\u0627\u0645\u062d\u062f\u0648\u062f \u062a\u0627 \u062a\u0627\u06cc\u06cc\u062f \u0646\u0647\u0627\u06cc\u06cc</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-clock"></i></div>
                <h4>\u062a\u062d\u0648\u06cc\u0644 \u0628\u0647\u200c\u0645\u0648\u0642\u0639</h4>
                <p>\u0631\u0639\u0627\u06cc\u062a \u062f\u0642\u06cc\u0642 \u0632\u0645\u0627\u0646\u200c\u0628\u0646\u062f\u06cc \u0648 \u062a\u062d\u0648\u06cc\u0644 \u067e\u0631\u0648\u0698\u0647 \u062f\u0631 \u0645\u0648\u0639\u062f \u0645\u0642\u0631\u0631</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="tez-section tez-cta-section">
    <div class="tez-container">
        <div class="tez-cta-content scroll-animate">
            <h2>\u0647\u0645\u06cc\u0646 \u0627\u0644\u0627\u0646 \u0633\u0641\u0627\u0631\u0634 \u062e\u0648\u062f \u0631\u0627 \u062b\u0628\u062a \u06a9\u0646\u06cc\u062f</h2>
            <p>\u0628\u0627 \u062a\u0645\u0627\u0633 \u06cc\u0627 \u0627\u0631\u0633\u0627\u0644 \u062f\u0631\u062e\u0648\u0627\u0633\u062a\u060c \u0645\u0634\u0627\u0648\u0631\u0647 \u0631\u0627\u06cc\u06af\u0627\u0646 \u062f\u0631\u06cc\u0627\u0641\u062a \u06a9\u0646\u06cc\u062f</p>
            <div class="tez-cta-buttons">
                <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-white tez-btn-lg"><i class="fa-solid fa-pen-to-square"></i> \u062b\u0628\u062a \u0633\u0641\u0627\u0631\u0634</a>
                <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-btn tez-btn-outline-white tez-btn-lg"><i class="fa-solid fa-phone"></i> <?php echo esc_html(defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : $phone); ?></a>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    'use strict';
    // Service accordion
    document.querySelectorAll('.tez-service-accordion-header').forEach(function(btn){
        btn.addEventListener('click',function(){
            var acc=this.closest('.tez-service-accordion');
            var body=acc.querySelector('.tez-service-accordion-body');
            var isActive=acc.classList.contains('active');
            // Close all others
            document.querySelectorAll('.tez-service-accordion.active').forEach(function(other){
                if(other!==acc){
                    other.classList.remove('active');
                    other.querySelector('.tez-service-accordion-header').setAttribute('aria-expanded','false');
                    other.querySelector('.tez-service-accordion-body').style.maxHeight=null;
                }
            });
            // Toggle current
            if(isActive){
                acc.classList.remove('active');
                this.setAttribute('aria-expanded','false');
                body.style.maxHeight=null;
            }else{
                acc.classList.add('active');
                this.setAttribute('aria-expanded','true');
                body.style.maxHeight=body.scrollHeight+'px';
                // Scroll into view
                setTimeout(function(){acc.scrollIntoView({behavior:'smooth',block:'nearest'});},100);
            }
        });
    });
    // Quick inquiry form
    var form=document.getElementById('tez-quick-inquiry-form');
    if(form){
        form.addEventListener('submit',function(e){
            e.preventDefault();
            var btn=form.querySelector('.tez-btn-submit');
            btn.classList.add('loading');
            // Simulate submission (replace with real AJAX)
            setTimeout(function(){
                btn.classList.remove('loading');
                btn.innerHTML='<i class="fa-solid fa-check"></i> \u062b\u0628\u062a \u0634\u062f!';
                btn.style.background='var(--tez-primary)';
                form.reset();
                setTimeout(function(){
                    btn.innerHTML='<i class="fa-solid fa-paper-plane"></i> \u0627\u0631\u0633\u0627\u0644';
                },3000);
            },1500);
        });
    }
})();
</script>

<?php
get_footer();
