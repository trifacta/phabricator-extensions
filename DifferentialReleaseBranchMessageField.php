<?php

final class DifferentialReleaseBranchMessageField
  extends DifferentialCommitMessageCustomField {

  const FIELDKEY = 'releaseRevision';

  public function getFieldName() {
    return pht('Release Branch');
  }

  public function getCustomFieldKey() {
    return 'trifacta:release-branch';
  }

  public function shouldAppearInCommitMessageTemplate() {
    return true;
  }

  public function renderFieldValue(array $handles) {
    return $this->getValue();
  }

  public function getFieldAliases() {
    return array(
      'Release Branch'
    );
  }

  public function isFieldEditable() {
    return true;
  }

  public function isTemplateField() {
    return true;
  }

  public function getFieldOrder() {
    return 1000000;
  }
}
