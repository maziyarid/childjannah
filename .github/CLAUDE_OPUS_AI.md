# 🤖 Claude Opus 4.6 AI Workflows

**Free, Unlimited AI Code Review & Improvement**

Powered by [Puter.js](https://puter.com) - No API keys, no costs, no limits!

---

## 🎯 Overview

This repository uses **Claude Opus 4.6** (Anthropic's most advanced model) to:

1. **🔍 Automatically review** every pull request
2. **✨ Auto-improve** code on demand
3. **🔒 Detect security** vulnerabilities
4. **♿ Ensure accessibility** (WCAG 2.1 AA)
5. **🌐 Validate Persian/RTL** support

**No cost to you** - Powered by Puter.js's "User-Pays" model!

---

## 🚀 Quick Start

### 1️⃣ Automatic Code Reviews

**Every time you open or update a PR**, Claude Opus 4.6 automatically:

- Analyzes all changed files
- Reviews for security, accessibility, performance
- Posts detailed feedback as a PR comment
- Provides actionable suggestions

**Example Review:**
```markdown
## 🤖 Claude Opus 4.6 Code Review

### 🎯 Executive Summary
This PR adds a new contact form with good structure but has 3 
accessibility issues and 1 security concern.

### 🔴 Critical Issues
1. **XSS Vulnerability** (line 45): User input not sanitized
2. **Missing ARIA labels** (lines 12-18): Form fields inaccessible

### 🟡 Warnings
1. **Focus management**: Modal doesn't trap focus
2. **RTL support**: Missing `direction: rtl` for Persian

### 🟢 Suggestions
1. Consider using `wp_kses_post()` for rich text
2. Add loading states for better UX
```

### 2️⃣ Manual Review

Need a fresh review? Comment on any PR:

```
/review
```

Claude will immediately analyze the code and post a new review.

---

## ✨ Auto-Improvement

### How It Works

1. Open a PR with your code
2. Wait for automatic review (optional)
3. Comment on the PR:
   ```
   /improve
   ```
4. Claude Opus 4.6 will:
   - Analyze all issues
   - Generate improved code
   - Create a new commit with fixes
   - Push to your PR branch

### What Gets Improved

| Category | Improvements |
|----------|-------------|
| ♿ **Accessibility** | Missing ARIA attributes, keyboard navigation, focus management, screen reader support |
| 🔒 **Security** | XSS prevention, input sanitization, output escaping, SQL injection fixes |
| ⚡ **Performance** | CSS optimization, DOM efficiency, lazy loading, caching |
| 🌐 **Persian/RTL** | Text direction, font fixes, right-to-left layout support |
| 📝 **Code Quality** | WordPress standards, best practices, maintainability |

### Example Workflow

```bash
# 1. Create PR
git checkout -b feature/new-widget
git push origin feature/new-widget
gh pr create --title "Add new widget"

# 2. Wait for automatic review (2-3 minutes)
# Claude posts detailed feedback

# 3. Request auto-improvements
# Comment "/improve" on the PR

# 4. Claude commits improvements
# New commit appears in your PR with fixes

# 5. Review changes and merge
git pull origin feature/new-widget
# Review the improvements
gh pr merge
```

---

## 📈 Features

### 🔍 Code Review Checks

#### Security Analysis
- ❌ XSS vulnerabilities
- ❌ SQL injection risks
- ❌ CSRF token validation
- ❌ Unescaped output
- ❌ Unsanitized input
- ✅ Proper use of WordPress sanitization functions

#### Accessibility Audit (WCAG 2.1 AA)
- ✅ Keyboard navigation (tabindex, focus)
- ✅ Screen reader support (ARIA attributes)
- ✅ Color contrast (4.5:1 minimum)
- ✅ Form labels and instructions
- ✅ Focus visible indicators
- ✅ No keyboard traps

#### Performance Optimization
- ⚡ CSS selector efficiency
- ⚡ JavaScript execution
- ⚡ DOM manipulation
- ⚡ Image optimization
- ⚡ Lazy loading

#### Persian/RTL Support
- 🌐 `direction: rtl` in CSS
- 🌐 Proper font fallbacks
- 🌐 Text alignment
- 🌐 Bidirectional text handling
- 🌐 Number formatting

#### WordPress Best Practices
- 📝 Coding standards (PHPCS)
- 📝 Hook usage
- 📝 Internationalization (i18n)
- 📝 Escape/sanitize functions
- 📝 Performance (transients, caching)

---

## 📝 Commands

### On Pull Requests

| Command | Action | When to Use |
|---------|--------|-------------|
| `/review` | Trigger manual code review | After pushing new changes, need fresh analysis |
| `/improve` | Auto-fix issues and commit | After review, want automated fixes |

### Comment Examples

```markdown
<!-- Simple review -->
/review

<!-- Request improvements -->
/improve

<!-- Both together -->
/review
/improve
```

---

## ⚙️ Configuration

### Models Available

You can modify `.github/workflows/*.yml` to use different models:

```yaml
model: 'claude-opus-4-6'      # Most powerful (default)
model: 'claude-sonnet-4-6'    # Balanced speed/quality
model: 'claude-haiku-4-5'     # Fastest
```

### Customizing Review Focus

Edit the prompt in `.github/workflows/claude-opus-reviewer.yml`:

```javascript
const reviewPrompt = `Review this code for:
1. Custom requirement 1
2. Custom requirement 2
...
${diffContent}`;
```

---

## 🔒 Safety & Privacy

### What Gets Shared

✅ **Shared with Puter.js/Claude:**
- Code diff (changed lines only)
- File names and paths
- Commit messages

❌ **NOT shared:**
- Repository secrets
- Environment variables
- Private API keys
- Database credentials

### Code Review Safety

- 👁️ **Always review AI suggestions** before accepting
- ✅ AI finds issues, but humans make final decisions
- 🔒 Test security fixes in staging environment
- 🧪 Verify accessibility improvements with real tools

---

## 🐛 Troubleshooting

### Review Didn't Post

**Check:**
1. Go to **Actions** tab in GitHub
2. Find the failed workflow run
3. Check logs for errors

**Common Issues:**
- Playwright installation timeout (increase timeout in workflow)
- Puter.js API temporary unavailable (retry)
- Browser launch failure (GitHub Actions limitation)

**Fix:**
```bash
# Re-trigger review
gh pr comment <PR_NUMBER> --body "/review"
```

### Improvements Not Applied

**Check:**
1. Verify you commented on a **pull request** (not an issue)
2. Check workflow permissions in repository settings
3. Ensure branch is not protected from bot commits

**Fix:**
```bash
# Give workflow write permissions
# Settings → Actions → General → Workflow permissions
# Select "Read and write permissions"
```

### Claude Response Too Slow

**Solutions:**
1. Use faster model: `claude-sonnet-4-6` or `claude-haiku-4-5`
2. Reduce diff size (split large PRs)
3. Increase timeout in workflow file

---

## 📊 Performance

### Typical Response Times

| Model | Review Time | Improvement Time |
|-------|-------------|------------------|
| Claude Opus 4.6 | 2-5 min | 3-8 min |
| Claude Sonnet 4.6 | 1-3 min | 2-5 min |
| Claude Haiku 4.5 | 30-90 sec | 1-3 min |

### Optimization Tips

1. **Smaller PRs** - Faster analysis (< 500 lines recommended)
2. **Focused changes** - Single purpose per PR
3. **Pre-review locally** - Fix obvious issues first

---

## 🔗 Resources

### Official Links
- [Puter.js Documentation](https://developer.puter.com/)
- [Claude Opus Guide](https://developer.puter.com/tutorials/free-unlimited-claude-35-sonnet-api/)
- [GitHub Actions Docs](https://docs.github.com/en/actions)

### Related Workflows
- `.github/workflows/claude-opus-reviewer.yml` - Main review workflow
- `.github/workflows/claude-auto-improve.yml` - Auto-improvement workflow

### Support
- **Issues:** Open GitHub issue with `ai-review` label
- **Questions:** Discuss in PR comments
- **Bugs:** Tag with `bug` and `claude-ai`

---

## ✨ Examples

### Example 1: Security Fix

**Before:**
```php
echo $_POST['user_input']; // ❌ XSS vulnerability
```

**Claude's Review:**
> 🔴 **Critical Security Issue**: Unescaped output allows XSS attacks

**After `/improve`:**
```php
echo esc_html($_POST['user_input']); // ✅ Safe
```

### Example 2: Accessibility Fix

**Before:**
```html
<button onclick="closeModal()">×</button>
```

**Claude's Review:**
> 🟡 **Accessibility Warning**: Missing accessible label for screen readers

**After `/improve`:**
```html
<button onclick="closeModal()" aria-label="بستن پنجره">×</button>
```

### Example 3: Persian/RTL Fix

**Before:**
```css
.widget { text-align: left; }
```

**Claude's Review:**
> 🟢 **Suggestion**: Add RTL support for Persian content

**After `/improve`:**
```css
.widget { text-align: right; direction: rtl; }
[dir="ltr"] .widget { text-align: left; direction: ltr; }
```

---

## 🎉 Benefits

### For Developers
- ✅ **24/7 code review** - Never wait for human reviewers
- ✅ **Learn best practices** - See expert-level suggestions
- ✅ **Catch bugs early** - Before they reach production
- ✅ **Free unlimited usage** - No API costs

### For Project Quality
- 🔒 **Better security** - Automated vulnerability detection
- ♿ **Improved accessibility** - WCAG 2.1 compliance
- ⚡ **Faster performance** - Optimization suggestions
- 🌐 **Persian support** - Proper RTL implementation

### For Team Workflow
- 🚀 **Faster PR merges** - Pre-reviewed code
- 📚 **Knowledge sharing** - Learn from AI feedback
- 🤝 **Consistent standards** - Automated enforcement
- 💡 **Continuous improvement** - Every PR gets better

---

## 🔮 Future Enhancements

**Planned Features:**
- [ ] WordPress plugin integration
- [ ] Frontend AI chat widget
- [ ] Automated testing generation
- [ ] Performance benchmarking
- [ ] Security scanning on schedule
- [ ] Multi-language support (beyond Persian)

---

## 📝 License

These workflows are part of the Jannah Child Theme.
Puter.js is free to use under their terms of service.

---

**Questions?** Open an issue or comment on any PR! 🚀

**Powered by [Puter.js](https://puter.com) + Claude Opus 4.6 🤖**
