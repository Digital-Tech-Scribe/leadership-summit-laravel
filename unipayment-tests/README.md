# UniPayment Test Suite

This directory contains all tests related to UniPayment integration, including:

## Test Categories

### Feature Tests
- Payment processing workflows
- Webhook handling and validation
- Admin payment management
- Error recovery and fallback mechanisms
- Security validation
- End-to-end payment journeys

### Unit Tests
- Payment controller methods
- UniPayment service classes
- Webhook signature validation
- Payment security middleware
- Request validation

### Models Tests
- Core application model tests (Event, Speaker, etc.)
- Relationship testing

## Running Tests

```bash
# Run all UniPayment tests
php artisan test

# Run specific test categories
php artisan test unipayment-tests/Feature
php artisan test unipayment-tests/Unit

# Run with coverage
php artisan test --coverage
```

## Test Results

Test results are stored in `storage/unipayment-test-results/` with timestamped directories for each test run.
