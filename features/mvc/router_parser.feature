Feature: Router Parser
    As Developer
    I want to have routing parser
    In order to store applications routings to be store in non-php files

    Background:
        Given I have Routing Parser

    Scenario: Unsupported Extension
        When I try parse routing "fixtures/routing/routing.txt"
        Then I will get empty array

    Scenario: Yaml support
        When I try parse routing "fixtures/routing/routing.yml"
        Then I will get array equal to json:
        """
        {"fileDownload":{"url":"\/file\/{hash}\/{file}.{extension}","action":"Asset::fileDownload"}}
        """