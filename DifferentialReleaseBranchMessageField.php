<?php

final class DifferentialReleaseBranchMessageField
  extends DifferentialCommitMessageCustomField {

  const FIELDKEY = 'trifacta:release-branch';

  public function getFieldName() {
    return pht('Release Branch');
  }

  public function getCustomFieldKey() {
    return 'trifacta:release-branch';
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
