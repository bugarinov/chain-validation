# Chain Validation

## Notice:
The latest build is 0.2.x and **is not backwards compatible** with 0.1.x versions. See *Migration* for details.
<br>
Alternatively, you can read [0.1.x-README.md](https://github.com/bugarinov/chain-validation/blob/master/0.1.x-README.md) for versions 0.1.x.

<br>

**Chain Validation** is a simple PHP library for handling very complex validations that goes beyond checking of data types, format and values of a given data. It uses the *Chain of Responsibility* design pattern in order to execute each validation in a consecutive manner. The execution will stop once an error occured during the validation process within a link. You can alter the data as it goes through the chain, depending on your requirements.

<br>

# Usage

### Defining and executing validations

Usage is simple. First, group your validations by purpose/relevance and create a new class for each validation group which extends the `AbstractLink` class. 
```php
class ValidationOne extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        // Run your validation process here which will
        // set the value of $validationFailed whether
        // the validation failed (true) or not (false)

        if ($validationFailed) {
            return new ResultFailed('your error message here', 400);
        }

        // If the validation did not fail, return an
        // evaluation result which contains the data
        return new ResultSuccess($data);
    }
}
```

You can run the validations using the `ChainValidation` class. The chain process each validation in exact order or in *First in, First out* manner.

```php
$chain = new ChainValidation();

$chain->add(new ValidationOne());
$chain->add(new ValidationTwo());
$chain->add(new ValidationThree());
$chain->add(new ValidationFour());

$validatedData = $chain->execute($data);
```

### Catching errors

To know whether an error occured or not, you can use the `hasError()` function of the `ChainValidation` class and get the error message using `getError()` function after the validation execution.

```php
$validatedData = $chain->execute($data);

if ($chain->hasError()) {
    throw new Exception($chain->getErrorMessage()); // or your preferred way of handling errors e.g. returing a response
}

// Some processes here if the validation succeeds e.g. committing of data to the database
```

If the chain validation succeeds, it will return the **validated data**, otherwise it will return `null`.

### Errors with a body

There are instances where errors messages are not enough, especially on front-end applications that highlight specific errors on their UI. Hence, a new parameter was added to the constructor of the `ResultFailed` class in order to pass the this data to the chain.

```php
    $errorBody = [
        'items_with_error' => [
            [
                'item_uid' => '100012',
                'reason' => 'something went wrong'
            ]
        ]
    ];

    return new ResultFailed('Some items have errors!', 400, $errorBody);
```
The error data can be obtained through the `getErrorBody()` function of the `ChainValidation` class and `LinkInterface` implementations.

```php
// Example of returning an error response using PSR's ResponseInterface

$validatedData = $chain->execute($data);

if ($chain->hasError()) {

    $payload = [
        'statusCode' => $chain->getErrorCode(),
        'error' => $chain->getErrorMessage(),
        'body' => $chain->getErrorBody()
    ];

    $response->getBody()
        ->write(json_encode($payload));

    return $response->withStatus($error_code)
        ->withHeader('Content-type', 'application/json');
}
```

<br>

# Migration from 0.1.x to 0.2.x

In order to migrate from 0.1.x to 0.2.x, you just need to replace the `execute` function on each link with the `evaluate` function.

From **v0.1.x**

```php
class ValidationOne extends AbstractLink
{
    public function execute(?array $data): ?array
    {
        if ($validationFailed) {
            return $this->throwError('your error message here', 400);
        }

        return $this->executeNext($data);
    }
}
```

to **v0.2.x**

```php
class ValidationOne extends AbstractLink
{
    public function evaluate(?array $data): EvaluationResult
    {
        if ($validationFailed) {
            return new ResultFailed('your error message here', 400);
        }

        return new ResultSuccess($data);
    }
}
```

<br>

# Tests

Run the tests using `composer test`.

[Tests](https://github.com/bugarinov/chain-validation/blob/master/tests/WithMockingTest.php) with mocking of `Link`'s `evaluate` function are added.
