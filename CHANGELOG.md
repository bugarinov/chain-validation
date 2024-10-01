# Changelog

# 0.2.1 - 2024-10-01
- Added error body handling on `EvaluationResult`, `ChainValidation` and `LinkInterface`.

# 0.2.0 - 2022-07-21
- Refactored `AbstractLink` and created class `EvaluationResult`. This is to allow unit testing for the chain validation, assuming each `link` will be treated as a `dependency` and the `evaluate` function will be mocked.

# 0.1.4 - 2022-07-20
- Created `LinkInterface` which is used as the base type when adding to chain instead of the `AbstractLink`.

# 0.1.3 - 2021-01-24
- Added optional parameter `$errorCode` to `AbstractLink` class `throwError()` function.