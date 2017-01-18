<?php

final class DifferentialReleaseBranchMessageField
  extends DifferentialCommitMessageField {

  const FIELDKEY = 'releaseRevision';

  public function getFieldName() {
    return pht('Release Branch');
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
}