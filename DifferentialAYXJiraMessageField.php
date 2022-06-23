<?php

final class DifferentialAYXJiraMessageField
  extends DifferentialCommitMessageCustomField {

  const FIELDKEY = 'trifacta:ayx-jira';

  public function getFieldName() {
    return pht('AYX Jira Issues');
  }

  public function getCustomFieldKey() {
    return 'trifacta:ayx-jira';
  }

  public function getFieldOrder() {
    return 1000000;
  }

  public function isFieldEditable() {
    return true;
  }

  public function isTemplateField() {
    return true;
  }

  public function renderFieldValue($value) {
    return $value;
  }
}
