# Contributing Guidelines

Thanks for helping improve the ChildJannah theme! This guide explains how to propose changes, run checks, and submit merge requests that can be reviewed quickly.

## 1. Prerequisites
- WordPress 6.4+ with the Jannah parent theme installed.
- PHP 8.1 or newer.
- Node.js 18+ (optional, only for linting or tooling scripts).
- GitLab account with access to `ada-ai1/childjannah`.

## 2. Branching & Commits
1. Create feature branches using the pattern `feature/<short-description>` (e.g., `feature/polls-dark-mode`).
2. Keep commits scoped and descriptive. Use the present tense ("Add icon map") and reference issues/MRs when applicable.
3. Avoid rebasing or force-pushing shared branches unless coordinated.

## 3. Code Style Expectations
- **PHP:** Follow WordPress coding standards. Wrap new functionality inside `inc/` modules. Guard every file with `if (!defined('ABSPATH')) exit;`.
- **CSS:** Append styles to the relevant file (`css/main.css`, `/page-templates.css`, etc.) and reuse custom properties defined in the design system.
- **JS:** Keep code modular inside `js/` and prefer vanilla JS. Use the accessibility helpers that already exist.
- **Docs:** Update `DEVELOPMENT_REPORT.md` and `CHANGELOG.md` whenever new functionality ships.

## 4. Tests & Checks
Before opening a merge request:
- Run `find . -name '*.php' -print0 | xargs -0 -n1 -P4 php -l` (or rely on the GitLab CI pipeline) to ensure all PHP files lint clean.
- Load the child theme in a staging site and smoke test custom templates (Homepage, Services, Inquiry, FAQ, Tag Hub).
- Validate forms, polls, star ratings, ToC, FAQ schema, and sitemap output in both light and dark/sepia modes.

## 5. Merge Request Checklist
- [ ] Rebase on the latest `main` (or the current feature branch) before pushing.
- [ ] Include screenshots or screen recordings for UI changes.
- [ ] Explain any new environment variables or assets that need to be uploaded (fonts, icons, etc.).
- [ ] Link related issues or tasks in the MR description.

## 6. Reporting Issues
Use GitLab issues to report bugs or feature ideas. Provide reproduction steps, expected vs. actual results, logs, and screenshots if relevant.

## 7. Getting Help
Open a discussion on the merge request, leave a comment on the issue, or reach out via the GitLab wiki if you need guidance.
