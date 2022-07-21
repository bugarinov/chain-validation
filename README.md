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
            return new EvaluationResult(null, 'your error message here', 400);
        }

        // If the validation did not fail, execute the
        // next link in the chain along with the data 
        // as the argument
        return new EvaluationResult($data);
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
    throw new Exception($chain->error); // or your preferred way of handling errors e.g. returing a response
}

// Some processes here if the validation succeeds e.g. committing of data to the database
```

If the chain validation succeeds, it will return the **validated data**, otherwise it will return `null`.

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
            return $this->throwError('your error message here');
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
            return new EvaluationResult(null, 'your error message here');
        }

        return new EvaluationResult($data);
    }
}
```

<br>

# Tests

Run the tests using `composer test`.

[Tests](https://github.com/bugarinov/chain-validation/blob/master/tests/WithMockingTest.php) with mocking of `Link`'s `evaluate` function are added.
