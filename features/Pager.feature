Feature: Pager
  Test Pager Service


  Scenario: Pager 1
    Given a Monitored Service in a Healthy State,
    When the Pager receives an Alert related to this Monitored Service,
    Then the Monitored Service becomes Unhealthy
    And the Pager notifies all targets of the first level of the escalation policy,
    And sets a 15-minutes acknowledgement delay

#  Scenario: Pager 2
#    Given a Monitored Service in an Unhealthy State
#    And the corresponding Alert is not Acknowledged
#    When the Pager receives the Acknowledgement Timeout,
#    Then the Pager notifies all targets of the next level of the escalation policy
#    And sets a 15-minutes acknowledgement delay.
#
#
#  Scenario: Pager 3
#    Given a Monitored Service in an Unhealthy State
#    And the corresponding Alert is not Acknowledged
#    When the Pager receives the Acknowledgement Timeout,
#    Then the Pager notifies all targets of the next level of the escalation policy
#    And sets a 15-minutes acknowledgement delay.
#
#  Scenario: Pager 4
#    Given a Monitored Service in an Unhealthy State
#    And the corresponding Alert is not Acknowledged
#    When the Pager receives the Acknowledgement Timeout,
#    Then the Pager notifies all targets of the next level of the escalation policy
#    And sets a 15-minutes acknowledgement delay.
#
#
#  Scenario: Pager 5
#    Given a Monitored Service in an Unhealthy State
#    And the corresponding Alert is not Acknowledged
#    When the Pager receives the Acknowledgement Timeout,
#    Then the Pager notifies all targets of the next level of the escalation policy
#    And sets a 15-minutes acknowledgement delay.