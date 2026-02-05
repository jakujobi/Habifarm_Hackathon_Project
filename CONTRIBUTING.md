# Contributing to Habifarm

Thank you for considering contributing to Habifarm! This document provides guidelines and instructions for contributing to this project.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Contribution Workflow](#contribution-workflow)
- [Coding Standards](#coding-standards)
- [Commit Messages](#commit-messages)
- [Pull Request Process](#pull-request-process)
- [Testing](#testing)

## Code of Conduct

### Our Pledge

We are committed to providing a welcoming and inspiring community for all. Please be respectful and constructive in all interactions.

### Expected Behavior

- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what is best for the community
- Show empathy towards other community members

### Unacceptable Behavior

- Harassment, intimidation, or discrimination
- Trolling, insulting/derogatory comments
- Publishing others' private information
- Other conduct which could reasonably be considered inappropriate

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce** the issue
- **Expected behavior** vs. actual behavior
- **Screenshots** if applicable
- **Environment details** (OS, PHP version, WordPress version, etc.)

**Bug Report Template:**

```markdown
### Description
[Clear description of the bug]

### Steps to Reproduce
1. Go to '...'
2. Click on '...'
3. See error

### Expected Behavior
[What you expected to happen]

### Actual Behavior
[What actually happened]

### Environment
- OS: [e.g., Ubuntu 22.04]
- PHP Version: [e.g., 8.1]
- WordPress Version: [e.g., 6.3]
- MySQL Version: [e.g., 8.0.33]
- Browser: [e.g., Chrome 115]

### Additional Context
[Any other relevant information]
```

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When suggesting an enhancement:

- **Use a clear title**
- **Provide detailed description** of the suggested enhancement
- **Explain why** this enhancement would be useful
- **List similar features** in other projects if applicable

### Contributing Code

You can contribute code by:

1. **Fixing bugs** - Look for issues labeled `bug`
2. **Implementing features** - Look for issues labeled `enhancement`
3. **Improving documentation** - Look for issues labeled `documentation`
4. **Writing tests** - Help increase code coverage
5. **Refactoring** - Improve code quality

## Development Setup

See [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) for detailed setup instructions.

**Quick Start:**

```bash
# Clone repository
git clone https://github.com/jakujobi/Habifarm_Hackathon_Project.git
cd Habifarm_Hackathon_Project

# Set up database
mysql -u root -p < habifarm/app/sql/local.sql

# Configure WordPress
# Edit habifarm/app/public/wp-config.php with your credentials

# For C++ development
cd "Cpp Impelemtation"
g++ -std=c++11 mainFile.cpp Habibit.cpp -o habibit
```

## Contribution Workflow

### 1. Fork and Clone

```bash
# Fork the repository on GitHub
# Then clone your fork
git clone https://github.com/YOUR-USERNAME/Habifarm_Hackathon_Project.git
cd Habifarm_Hackathon_Project

# Add upstream remote
git remote add upstream https://github.com/jakujobi/Habifarm_Hackathon_Project.git
```

### 2. Create a Branch

```bash
# Update main branch
git checkout main
git pull upstream main

# Create feature branch
git checkout -b feature/your-feature-name

# OR for bug fixes
git checkout -b fix/bug-description
```

**Branch Naming Conventions:**
- `feature/feature-name` - New features
- `fix/bug-description` - Bug fixes
- `docs/update-description` - Documentation updates
- `refactor/component-name` - Code refactoring
- `test/test-description` - Test additions

### 3. Make Changes

- Write clean, readable code
- Follow existing code style
- Add comments for complex logic
- Update documentation if needed

### 4. Commit Changes

```bash
# Stage changes
git add .

# Commit with descriptive message
git commit -m "Add feature: equipment search filter"

# OR for multiple logical changes
git add file1.php
git commit -m "Fix: equipment pricing calculation"
git add file2.php
git commit -m "Add: validation for rental dates"
```

### 5. Keep Branch Updated

```bash
# Fetch upstream changes
git fetch upstream

# Rebase on upstream main
git rebase upstream/main

# Resolve conflicts if any
# Then continue rebase
git add .
git rebase --continue
```

### 6. Push Changes

```bash
# Push to your fork
git push origin feature/your-feature-name

# If rebased, force push
git push -f origin feature/your-feature-name
```

### 7. Create Pull Request

1. Go to your fork on GitHub
2. Click "Pull Request"
3. Select your branch
4. Fill in PR template
5. Submit

## Coding Standards

### PHP/WordPress

Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/):

```php
<?php
/**
 * Function description
 *
 * @param string $param Parameter description.
 * @return bool Return value description.
 */
function habifarm_custom_function( $param ) {
    // Use tabs for indentation
    if ( 'value' === $param ) {
        return true;
    }
    return false;
}
```

**Key Points:**
- Tabs for indentation
- Spaces around parentheses
- Yoda conditions (`'value' === $var`)
- Snake_case for functions and variables
- Sanitize input, escape output

### C++

```cpp
// File: MyClass.h
#ifndef MYCLASS_H
#define MYCLASS_H

/**
 * Class description
 */
class MyClass {
public:
    /**
     * Constructor
     * @param name Object name
     */
    MyClass(const std::string& name);
    
    /**
     * Get name
     * @return Name string
     */
    std::string getName() const;

private:
    std::string name;
};

#endif // MYCLASS_H
```

**Key Points:**
- Use include guards
- 4 spaces for indentation
- CamelCase for classes
- camelCase for methods/variables
- Document public APIs
- Use const correctness

### JavaScript

```javascript
/**
 * Class description
 */
class EquipmentManager {
  /**
   * Constructor
   * @param {Array} items - Initial equipment list
   */
  constructor(items = []) {
    this.items = items;
  }
  
  /**
   * Add equipment
   * @param {Object} equipment - Equipment object
   * @returns {number} New array length
   */
  addEquipment(equipment) {
    return this.items.push(equipment);
  }
}
```

**Key Points:**
- 2 spaces for indentation
- camelCase for variables/functions
- PascalCase for classes
- Use JSDoc comments
- Use const/let, avoid var
- Modern ES6+ syntax

## Commit Messages

Follow [Conventional Commits](https://www.conventionalcommits.org/):

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style (formatting, no code change)
- **refactor**: Code refactoring
- **test**: Adding tests
- **chore**: Build process, tooling

### Examples

```bash
# Simple feature
git commit -m "feat: add equipment availability filter"

# Bug fix with scope
git commit -m "fix(checkout): correct tax calculation rounding"

# Breaking change
git commit -m "feat!: change rental period to hours instead of days

BREAKING CHANGE: Rental periods are now calculated in hours
instead of days. Update all existing rental records."

# Multiple paragraphs
git commit -m "refactor: improve equipment search performance

- Add database indexes on equipment name and category
- Implement caching for frequently searched terms
- Optimize SQL queries

Closes #123"
```

### Commit Message Rules

1. **Subject line:**
   - Max 50 characters
   - Start with lowercase (after type)
   - No period at end
   - Imperative mood ("add" not "added")

2. **Body (optional):**
   - Wrap at 72 characters
   - Explain what and why, not how
   - Separate from subject with blank line

3. **Footer (optional):**
   - Reference issues: `Closes #123` or `Fixes #456`
   - Note breaking changes: `BREAKING CHANGE: description`

## Pull Request Process

### Before Submitting

- [ ] Code follows project style guidelines
- [ ] Self-review of code completed
- [ ] Comments added for complex code
- [ ] Documentation updated if needed
- [ ] No new warnings or errors
- [ ] Manual testing completed
- [ ] Branch is up to date with main

### PR Title Format

Use same format as commit messages:

```
feat: add vendor rating system
fix: resolve equipment duplicate listing bug
docs: update installation instructions
```

### PR Description Template

```markdown
## Description
[Brief description of changes]

## Type of Change
- [ ] Bug fix (non-breaking change fixing an issue)
- [ ] New feature (non-breaking change adding functionality)
- [ ] Breaking change (fix or feature causing existing functionality to break)
- [ ] Documentation update

## Testing
[Describe testing performed]

## Screenshots (if applicable)
[Add screenshots]

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No new warnings
- [ ] Manual testing completed

## Related Issues
Closes #[issue number]
```

### Review Process

1. **Automated checks** (if configured)
   - Code style validation
   - Build verification

2. **Code review** by maintainer(s)
   - Functionality check
   - Code quality review
   - Security review

3. **Requested changes**
   - Address all feedback
   - Push new commits
   - Request re-review

4. **Approval and merge**
   - Maintainer approves
   - PR merged to main
   - Branch can be deleted

### After Merge

```bash
# Switch to main
git checkout main

# Pull merged changes
git pull upstream main

# Delete feature branch
git branch -d feature/your-feature-name

# Delete remote branch
git push origin --delete feature/your-feature-name
```

## Testing

### Manual Testing Checklist

**WordPress Features:**
- [ ] Vendor registration works
- [ ] Equipment can be added/edited/deleted
- [ ] Equipment catalog displays correctly
- [ ] Search functionality works
- [ ] Checkout process completes
- [ ] Order emails sent correctly
- [ ] Admin dashboard accessible

**C++ Application:**
- [ ] Compiles without errors/warnings
- [ ] Account creation works
- [ ] Login authentication works
- [ ] Equipment can be added
- [ ] Equipment listing displays
- [ ] Rental calculation correct (2.5% tax)
- [ ] Checkout completes

### Testing for Different Platforms

**Windows:**
```bash
# Test C++ compilation with MSVC
cl /EHsc mainFile.cpp Habibit.cpp
```

**macOS:**
```bash
# Test C++ compilation
clang++ -std=c++11 mainFile.cpp Habibit.cpp -o habibit
```

**Linux:**
```bash
# Test C++ compilation
g++ -std=c++11 mainFile.cpp Habibit.cpp -o habibit
```

## Areas Needing Contribution

### High Priority

1. **Payment Gateway Integration**
   - Stripe/PayPal integration
   - Order status tracking

2. **Automated Testing**
   - PHPUnit tests for WordPress
   - Google Test for C++
   - Jest for JavaScript

3. **Security Enhancements**
   - Input validation
   - XSS prevention
   - CSRF protection

### Medium Priority

1. **UI/UX Improvements**
   - Responsive design enhancements
   - Accessibility improvements
   - Mobile app mockups

2. **Documentation**
   - API documentation
   - User guides
   - Video tutorials

3. **Performance**
   - Database query optimization
   - Caching implementation
   - Image optimization

### Good First Issues

Look for issues labeled `good first issue`:
- Documentation fixes
- Small bug fixes
- Code comments
- Test additions

## Questions?

- **General questions:** Open a GitHub Discussion
- **Bug reports:** Create a GitHub Issue
- **Security issues:** See [SECURITY.md](SECURITY.md)

## License

By contributing, you agree that your contributions will be licensed under the same license as the project (GNU GPL v3.0).

## Thank You!

Your contributions make Habifarm better for everyone. We appreciate your time and effort!
