## Initial database setup
`php artisan migrate:fresh --seed`

## Setting up admin account
`php artisan make:admin`

## Test
- Test only includes feature testing for 'drawing', and 'winning number generation' feature.
run `vendor/bin/phpunit` in the project root to run the test cases.
