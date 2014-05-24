Feature: Translate File Adapter
    In order to easily load translations from php file
    As Developer
    I need Translate File Adapter

    Background:
        Given I have Translate constructed with "fixtures/i18n/en.php"

    Scenario: Load translation from php file
        When I will try to query hello
        Then I will get Hello