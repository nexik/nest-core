Feature: Registry
    In order to storing data
    As Developer
    I need Registry as place where I will store and get data by key

    Background:
        Given I have Registry

    Scenario: Getting null for non existed key
        When I try to get data for non_existed
        Then I will get null value

    Scenario: Getting default value for non existed key
        When I try to get data for non_existed with default default
        Then I will get default

    Scenario: Getting value before stored
        Given I store bar with key foo
        When I try to get data for foo
        Then I will get bar