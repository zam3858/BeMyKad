# Contributing to BeMyKad

Thank you for considering contributing to `BeMyKad`! We welcome contributions that help improve and expand this PHP package for managing Malaysian MyKad numbers. Please read the following guidelines to ensure a smooth contribution process.

## Getting Started

1. **Fork the repository**: Start by forking the `BeMyKad` repository to your GitHub account.
2. **Clone the fork**: Clone your forked repository to your local development environment.

    ```bash
    git clone https://github.com/your-username/bemykad.git
    ```

3. **Set up the project**: Install the dependencies by running:

    ```bash
    composer install
    ```

4. **Create a new branch**: Use a descriptive branch name that explains your feature or fix, for example:

    ```bash
    git checkout -b feature-new-functionality
    ```

## Code Style

We follow PSR-12 standards for PHP coding style. Please ensure your code adheres to these standards by running PHP-CS-Fixer or similar tools.

## Making Changes

### Adding New Features or Fixes

1. **Scope your changes**: Make sure your code solves one specific problem or introduces one feature per pull request.
2. **Document your code**: Add comments to explain the purpose of new methods or classes.
3. **Write tests**: Any new features or bug fixes should include relevant tests. Refer to the `tests` directory for examples of existing tests.
4. **Run tests**: Ensure that all tests pass before submitting your code. You can run the tests with:

    ```bash
    composer test
    ```

### Updating Documentation

If your changes affect usage or introduce new features, update the `README.md` and add any necessary documentation to explain the changes.

## Commit Messages

Please use descriptive commit messages that clearly explain what your code does. Follow this format:

- **Fix**: For bug fixes
- **Add**: For new features or files
- **Update**: For updates to existing functionality
- **Refactor**: For code refactoring that doesn’t change functionality
- **Docs**: For documentation updates

Example:

```plaintext
Add validation for new MyKad formats
```

## Pull Request Process

1. **Push your branch**: Push your branch to your fork on GitHub.

    ```bash
    git push origin feature-new-functionality
    ```

2. **Submit a pull request**: Go to the main repository on GitHub, and submit a pull request from your fork.
3. **Describe your changes**: Provide a brief description of the changes you made and the problem it solves.

### Code Review

Your pull request will be reviewed, and you may receive feedback. Please address any requested changes and update your pull request. We strive to review PRs in a timely manner and will keep you updated on any required changes or when it is ready for merging.

## Issues and Feature Requests

If you encounter a bug or have an idea for a new feature, please create an issue on GitHub. Include as much detail as possible so we can understand and address it effectively.

---

Thank you for contributing to `BeMyKad`! We appreciate your effort in helping make this package better for everyone.
