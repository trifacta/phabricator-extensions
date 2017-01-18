<?php

final class DifferentialReleaseBranchField
  extends DifferentialStoredCustomField {

  public function getFieldKey() {
    return 'trifacta:release-branch';
  }

  public function getFieldName() {
    return pht('Release Branch');
  }

  public function getFieldDescription() {
    return pht('Indicates the intended branch for this revision.');
  }

  public function getHeraldFieldStandardType() {
    return 'standard.text';
  }

  public function getHeraldFieldValueType($condition) {
    return new HeraldTextFieldValue();
  }

  public function getHeraldFieldConditions() {
    return array(
      HeraldAdapter::CONDITION_CONTAINS,
      HeraldAdapter::CONDITION_NOT_CONTAINS,
      HeraldAdapter::CONDITION_IS,
      HeraldAdapter::CONDITION_IS_NOT,
      HeraldAdapter::CONDITION_REGEXP,
    );
  }

  public function shouldAppearInHerald() {
    return true;
  }

  public function getHeraldFieldValue() {
    return $this->getValue();
  }

  public function shouldDisableByDefault() {
    return false;
  }

  public function shouldAppearInPropertyView() {
    return true;
  }

  public function renderPropertyViewLabel() {
    return $this->getFieldName();
  }

  public function renderPropertyViewValue(array $handles) {
    if (!strlen($this->getValue())) {
      return null;
    }

    return $this->getValue();
  }

  public function shouldAppearInApplicationTransactions() {
    return true;
  }

  public function getOldValueForApplicationTransactions() {
    return $this->getValue();
  }

  public function getNewValueForApplicationTransactions() {
    return $this->getValue();
  }

  public function shouldAppearInEditView() {
    return true;
  }

  public function renderEditControl(array $handles) {
    return id(new AphrontFormTextControl())
      ->setName($this->getFieldKey())
      ->setValue($this->getValue())
      ->setLabel($this->getFieldName());
  }

  public function readValueFromRequest(AphrontRequest $request) {
    $this->setValue($request->getStr($this->getFieldKey()));
  }

  public function getApplicationTransactionTitle(
    PhabricatorApplicationTransaction $xaction) {
    $author_phid = $xaction->getAuthorPHID();
    $old = $xaction->getOldValue();
    $new = $xaction->getNewValue();

    return pht(
      '%s edited the release branch: "%s" became "%s".',
      $xaction->renderHandleLink($author_phid),
      $old,
      $new);
  }

  public function getApplicationTransactionTitleForFeed(
    PhabricatorApplicationTransaction $xaction) {

    $object_phid = $xaction->getObjectPHID();
    $author_phid = $xaction->getAuthorPHID();
    $old = $xaction->getOldValue();
    $new = $xaction->getNewValue();

    return pht(
      '%s edited the release branch for %s: "%s" became "%s".',
      $xaction->renderHandleLink($author_phid),
      $xaction->renderHandleLink($object_phid),
      $old,
      $new);
  }

  public function shouldAppearInConduitDictionary() {
    return true;
  }

  public function shouldAppearInConduitTransactions() {
    return true;
  }

  protected function newConduitEditParameterType() {
    return new ConduitStringParameterType();
  }

}
