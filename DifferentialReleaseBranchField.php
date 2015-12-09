<?php

final class DifferentialReleaseBranchField
  extends DifferentialStoredCustomField {

  public function getFieldType() {
    return 'text';
  }

  public function getFieldKey() {
    return 'trifacta:release-branch';
  }

  public function getFieldKeyForConduit() {
    return 'releaseRevision';
  }

  public function getFieldName() {
    return pht('Release Branch');
  }

  public function getFieldDescription() {
    return pht('Indicates the intended branch for this revision.');
  }

  /**
   * @brief See https://secure.phabricator.com/D13612
   */
  protected function getHeraldFieldStandardType() {
    return self::STANDARD_TEXT;
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
    return $this->getValue();
  }

  public function shouldAppearInEditView() {
    return true;
  }

  public function shouldAppearInApplicationTransactions() {
    return true;
  }

  public function shouldAppearInCommitMessageTemplate() {
    return true;
  }

  public function getOldValueForApplicationTransactions() {
    return $this->getValue();
  }

  public function getNewValueForApplicationTransactions() {
    return $this->getValue();
  }

  public function readValueFromRequest(AphrontRequest $request) {
    $this->setValue($request->getStr($this->getFieldKey()));
  }

  public function renderEditControl(array $handles) {
    return id(new AphrontFormTextControl())
      ->setName($this->getFieldKey())
      ->setValue($this->getValue())
      ->setLabel($this->getFieldName());
  }

  public function getApplicationTransactionTitle(
    PhabricatorApplicationTransaction $xaction) {
    $author_phid = $xaction->getAuthorPHID();
    $old = $xaction->getOldValue();
    $new = $xaction->getNewValue();

    return pht(
      '%s updated the release branch for this revision.',
      $xaction->renderHandleLink($author_phid));
  }

  public function getApplicationTransactionTitleForFeed(
    PhabricatorApplicationTransaction $xaction) {

    $object_phid = $xaction->getObjectPHID();
    $author_phid = $xaction->getAuthorPHID();
    $old = $xaction->getOldValue();
    $new = $xaction->getNewValue();

    return pht(
      '%s updated the release branch for %s.',
      $xaction->renderHandleLink($author_phid),
      $xaction->renderHandleLink($object_phid));
  }

  public function shouldAppearInCommitMessage() {
    return true;
  }

  public function shouldAllowEditInCommitMessage() {
    return true;
  }

  public function shouldOverwriteWhenCommitMessageIsEdited() {
    return true;
  }

  public function getCommitMessageLabels() {
    return array(
      'Release Branch'
    );
  }

  public function renderCommitMessageValue(array $handles) {
    return $this->getValue();
  }

  public function shouldAppearInConduitDictionary() {
    return true;
  }

  // Copied from phabricator/src/infrastructure/customfield/standard/PhabricatorStandardCustomFieldText.php

  public function buildFieldIndexes() {
    $indexes = array();

    $value = $this->getFieldValue();
    if (strlen($value)) {
      $indexes[] = $this->newStringIndex($value);
    }

    return $indexes;
  }

  public function readApplicationSearchValueFromRequest(
    PhabricatorApplicationSearchEngine $engine,
    AphrontRequest $request) {

    return $request->getStr($this->getFieldKey());
  }

  public function applyApplicationSearchConstraintToQuery(
    PhabricatorApplicationSearchEngine $engine,
    PhabricatorCursorPagedPolicyAwareQuery $query,
    $value) {

    if (strlen($value)) {
      $query->withApplicationSearchContainsConstraint(
        $this->newStringIndex(null),
        $value);
    }
  }

  public function appendToApplicationSearchForm(
    PhabricatorApplicationSearchEngine $engine,
    AphrontFormView $form,
    $value) {

    $form->appendChild(
      id(new AphrontFormTextControl())
        ->setLabel($this->getFieldName())
        ->setName($this->getFieldKey())
        ->setValue($value));
  }

  public function readValueFromCommitMessage($value) {
    $this->setValue($value);
    return $this;
  }

}
