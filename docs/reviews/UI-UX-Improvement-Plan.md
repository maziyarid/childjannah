# UI/UX Analysis and Improvement Plan for Teznevisan3.com

## Methodology

To assess the usability and accessibility of Teznevisan3.com, the home page was viewed in a desktop browser, and navigation elements and interactive controls were exercised. The site content was also examined through the browser tool to obtain text for citation. Independent design guidelines from the W3C Web Accessibility Initiative (WAI) and government accessibility guides were consulted to identify best-practice requirements for color contrast, navigation, button design, image descriptions and form labeling. These guidelines form the basis for the recommendations below.

## Key Findings

### 1. Language and Navigation

- **No language switcher** – the entire site is in Persian/Farsi and lacks an English version. Non-Persian speakers cannot understand the page or navigation. There is no `<html lang>` attribute to announce the language to browsers.
- **Broken/unclear links** – the navigation menu includes a Blog link that, when selected, loads a blank page. This appears to be a routing bug. Several menu items expand on hover but lack visual cues for keyboard users.
- **Side-floating widget confusion** – a vertical widget on the left displays icons for search, dark/light mode and font size adjustment. The icons have no text labels and rely solely on color or iconography. Clicking the "+" icon collapses the widget to a single arrow; there is no obvious way to restore the controls. This behaviour is unexpected and can be regarded as a bug.

### 2. Color Contrast and Visual Hierarchy

- **Low contrast buttons and text** – the primary call-to-action (CTA) button "ثبت سفارش" has nearly the same green color as the surrounding banner, making it difficult to discern. Some headings and captions are light gray on white or dark backgrounds with insufficient contrast (for example, the step numbers in the ordering process). W3C guidelines state that foreground text must have sufficient contrast against its background and that this applies to text on images, gradients and buttons. Digital.gov further recommends a contrast ratio of at least 4.5:1 for small text and 3:1 for large text.
- **Color used as the only indicator** – the side-floating icons rely on color changes to indicate state; users with color-vision impairments may not detect whether a control is selected. Guidelines advise against using color alone to convey information.
- **Inconsistent hierarchy** – important actions such as ordering or contacting the team are placed far down the page. The hero section describes services but forces users to scroll before seeing a CTA. Government accessibility guidance stresses that key information should be discernible at a glance and that important actions should be placed where users can easily find them.

### 3. Buttons and Interactive Elements

- **Poorly labelled icons** – interactive icons (search, moon, gear, plus/minus) have no textual label or accessible name. W3C recommends that interactive elements be easy to identify and not rely solely on icons or color.
- **Small clickable areas** – some buttons and icons appear small relative to standard cursor size. The AudioEye accessibility guide notes that a minimum target size of 24 × 24 CSS pixels improves clickability.
- **Low-contrast CTAs** – button text does not stand out from the button background, violating the recommended 4.5:1 contrast ratio between button text and its background and 3:1 between the button and the page background.
- **Ambiguous button text** – the primary CTA "ثبت سفارش" (register order) is descriptive for Persian speakers but is inaccessible to screen readers because alt/ARIA labels are missing. The buttons also lack visible focus states and do not provide keyboard navigability.

### 4. Content Layout and Structure

- **Lengthy, animation-heavy page** – the home page uses multiple animated sections that fade in as the user scrolls. While visually engaging, these animations delay content visibility and may hinder users with motion sensitivity or older devices.
- **Unstructured headings** – the page uses styled text rather than semantic heading tags in some areas; this reduces accessibility and search-engine indexing. Proper heading levels and grouping help users understand content. W3C emphasises using headings and spacing to group related content.
- **Forms without labels** – the search box and order form fields (accessed via "ثبت سفارش") do not display explicit labels. W3C's forms tutorial explains that each form control should be associated with a `<label>` element describing its purpose. Without labels, screen readers cannot announce the field's purpose.

### 5. Images and Alt Text

- **Missing alternative text** – many decorative and illustrative images lack alt attributes. W3C's image guidelines state that images must have text alternatives describing their information or function. Functional images (such as icons used as links) should describe the intended action.

### 6. Performance and Technical Bugs

- **Broken blog page** – selecting "بلاگ" results in a blank page, indicating a broken route or script error.
- **Widget toggle bug** – the side-floating widget collapses when clicking "+" and cannot be expanded again, leaving the search button inaccessible.
- **Slow load and heavy animations** – the large number of animations and background effects slow down page rendering and may hinder access on slower connections.

## Improvement Plan and Instructions

The following step-by-step instructions address the identified issues. Assign tasks to developers, designers and content editors as appropriate.

### 1. Add Multilingual Support and Fix Navigation

- **Set document language attributes** – add `lang="fa"` to the `<html>` tag for Farsi pages. Provide an English translation of key pages (home, services, about, contact) and create a language switcher in the header. The switcher should be accessible via keyboard and have descriptive labels (e.g., "English | فارسی").
- **Audit navigation links** – test all menu items (especially "بلاگ") and ensure they load correctly. Fix broken routes, remove dead links, and implement server-side redirects where necessary.
- **Provide keyboard navigation cues** – ensure that menu items highlight on focus (using `:focus` CSS selectors) and can be expanded by keyboard (e.g., using Enter to open drop-down menus). Provide ARIA roles (`role="menu"`, `role="menuitem"`) and attributes (`aria-haspopup`, `aria-expanded`) to describe state for assistive technologies.
- **Streamline the side-floating widget** – redesign the vertical widget to use recognizable icons accompanied by visible text labels or tooltips. Add `aria-label` attributes to each control ("Search", "Increase font size", "Decrease font size", "Toggle dark mode"). Make sure clicking the collapse/expand button toggles the full list and that this state is keyboard accessible. Provide contrast and focus styles so users can identify which control is active.

### 2. Improve Color Contrast and Visual Hierarchy

- **Audit color palette** – use tools like WebAIM's color contrast checker to test color pairs. Adjust green backgrounds and white/grey text to meet WCAG 2.1 Level AA contrast ratios of 4.5:1 for normal text and 3:1 for large text. For example, darken the button background or lighten the text.
- **Strengthen call-to-action prominence** – place the primary "ثبت سفارش" button higher on the page (e.g., within the hero section) and style it with strong contrast against the background. Include white space around the CTA to draw attention. Ensure the button's border and shadow differentiate it from the background.
- **Avoid color-only indicators** – whenever color changes indicate state (e.g., active icon), supplement with an icon change or underline. W3C advises not to use color alone to convey information.
- **Minimize unnecessary animations** – reduce or remove fade-in effects that delay content. Provide a "Reduce motion" preference (via CSS `prefers-reduced-motion`) to respect users' settings.

### 3. Redesign Buttons and Interactive Controls

- **Use semantic `<button>` elements** – replace `<a>` elements styled as buttons with `<button>` tags to ensure native keyboard and screen-reader support. Add descriptive text within the button ("ثبت سفارش – ثبت سفارش درخواست پروژه"), and include `aria-label` attributes for icons.
- **Ensure adequate size and spacing** – enlarge small icons and buttons to at least 24 × 24 px with sufficient padding. Group controls with consistent spacing so they are easy to click or tap.
- **Meet contrast requirements** – set button text and background colors to meet the recommended contrast ratios (4.5:1 text-to-button, 3:1 button-to-background). Use accessible color schemes and test with a contrast checker.
- **Provide visible focus states** – define `:focus` styles (e.g., outline or border change) for buttons and links so that keyboard users can track their position. Provide hover and active states with distinct visual cues.
- **Keyboard accessibility** – ensure all buttons are reachable via the Tab key and can be activated with Enter or Space. Use ARIA attributes (`aria-pressed`, `aria-expanded`) where necessary to communicate state.

### 4. Structure Content and Labels

- **Use semantic headings** – restructure the page with `<h1>` for the main title, followed by `<h2>` for major sections ("خدمات ما", "مراحل انجام سفارش") and `<h3>` for subheadings. This improves navigation for screen readers and meets the recommendation to use headings and spacing to group related content.
- **Group related content** – group service cards and step descriptions using lists or sectioning elements (`<section>`, `<ul>`). Provide consistent spacing and clear separation to help users scan the page quickly.
- **Label all form controls** – for the search field and order form, add `<label>` elements that describe the purpose of each input. The label's `for` attribute should match the input's `id`. For example:

```html
<label for="order-name">نام شما:</label>
<input id="order-name" name="name" type="text" required>
```

Hidden labels can be visually hidden but available to assistive technologies when the context is obvious.

- **Provide feedback and error messages** – ensure that form submissions give feedback (success confirmation, validation errors) with clear language. Use `aria-live` regions to announce dynamic updates.

### 5. Add Alternative Text for Images

- **Audit all images** – identify every image on the site and assign appropriate alt attributes. Informative images should have short descriptions of their content. Decorative images (e.g., background patterns) should have empty `alt=""` to avoid redundancy.
- **Describe functional icons** – for icons used as buttons or links (e.g., search, dark mode), the alt text (or `aria-label`) should describe the action ("جستجو", "تغییر حالت تاریک") rather than the icon's shape.
- **Avoid text embedded in images** – where possible, replace images of text with actual HTML text to ensure it scales and can be translated or read by screen readers.

### 6. Optimize Performance and Fix Technical Bugs

- **Fix broken pages** – debug the blog route so that clicking "بلاگ" loads the blog index rather than a blank page. Check console logs and network requests to identify script errors.
- **Resolve widget collapse bug** – adjust the JavaScript controlling the side widget so that the collapse/expand toggle reliably shows and hides the controls. Provide an accessible name and ensure the collapsed state can be reversed.
- **Optimize images and animations** – compress large images and remove unnecessary animations. Use lazy loading (`loading="lazy"`) for images below the fold and test the site on slower connections.
- **Implement caching and minification** – enable server-side caching, minify CSS/JS and use a content-delivery network (CDN) to improve load times.

### 7. Testing and Validation

- **Accessibility testing** – use automated tools (Wave, Axe) and manual testing with screen readers (NVDA, VoiceOver) to verify that alt text, form labels and keyboard navigation work as expected. Consult W3C's checklist for accessible design.
- **Contrast testing** – test color contrast using WebAIM's contrast checker and update your style sheet accordingly.
- **Responsive testing** – test the site on various devices and viewport sizes to ensure that content reflows correctly. Provide breakpoints to adjust layout for mobile screens and preserve readability.
- **User feedback** – after making changes, collect feedback from actual users (including people with disabilities) to ensure the improvements meet real needs. Iterate based on feedback.

## Conclusion

Teznevisan3.com provides valuable academic services but currently suffers from usability and accessibility issues that hinder many users. By following the structured instructions above—particularly adhering to internationally recognised accessibility guidelines—you will create a more inclusive, user-friendly site. Prioritising clear navigation, high-contrast design, descriptive labels and responsive performance will help visitors quickly understand the services offered and complete their tasks.