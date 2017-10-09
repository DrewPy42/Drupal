<?php
/**
 * @file
 * Contains \Drupal\migrate_custom\Plugin\migrate\source\User.
 */
 
namespace Drupal\migrate_jcl\Plugin\migrate\source;
 
use Drupal\migrate\Row;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

 
/**
 * Extract users from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "custom_user"
 * )
 */

class User extends SqlBase {
 
  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('users', 'u')
      ->fields('u', array_keys($this->baseFields()))
      ->condition('uid', 0, '>');
  }
 
  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->baseFields();
    $fields['first_name'] = $this->t('First Name');
    $fields['last_name'] = $this->t('Last Name');
    $fields['picture'] = $this->t('Picture');
    $fields['hover_picture'] = $this->t('Hover Picture');
    $fields['about_us'] = $this->t('About Us?');
    $fields['library_admin'] = $this->t('Library Admin');
    $fields['animal_image'] = $this->t('Favorite Animal Image');
    $fields['animal_text'] = $this->t('Favorite Animal Text');
    $fields['position'] = $this->t('Position');
    $fields['bibliocommons_link'] = $this->t('Bibliocommons Profile');
    $fields['fun_fact'] = $this->t('Fun Fact');
    $fields['current_read'] = $this->t('Currently reading');
    $fields['favorite_read'] = $this->t('Favorite read');
    $fields['location'] = $this->t('Location');
    $fields['department'] = $this->t('Department');
    $fields['manager_type'] = $this->t('Branch Manager Type');
    $fields['phone'] = $this->t('phone');
    return $fields;
  }
 
  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $uid = $row->getSourceProperty('uid');
 
    // first_name
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_firstname_value
      FROM
        {field_data_field_useracct_firstname} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('first_name', $record->field_useracct_firstname_value );
    }
 
    // last_name
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_lastname_value
      FROM
        {field_data_field_useracct_lastname} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('last_name', $record->field_useracct_lastname_value );
    }
 
    // user_image
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_img_fid,
        fld.field_useracct_img_alt,
        fld.field_useracct_img_title,
        fld.field_useracct_img_width,
        fld.field_useracct_img_height
      FROM
        {field_data_field_useracct_img} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    $images = [];
    foreach ($result as $record) {
      $images[] = [
        'target_id' => $record->field_useracct_img_fid,
        'alt' => $record->field_useracct_img_alt,
        'title' => $record->field_useracct_img_title,
        'width' => $record->field_useracct_img_width,
        'height' => $record->field_useracct_img_height,
      ];
    }
    $row->setSourceProperty('user_image', $images);

     // hover_image
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_hoverimg_fid,
        fld.field_useracct_hoverimg_alt,
        fld.field_useracct_hoverimg_title,
        fld.field_useracct_hoverimg_width,
        fld.field_useracct_hoverimg_height
      FROM
        {field_data_field_useracct_hoverimg} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    $images = [];
    foreach ($result as $record) {
      $images[] = [
        'target_id' => $record->field_useracct_hoverimg_fid,
        'alt' => $record->field_useracct_hoverimg_alt,
        'title' => $record->field_useracct_hoverimg_title,
        'width' => $record->field_useracct_hoverimg_width,
        'height' => $record->field_useracct_hoverimg_height,
      ];
    }
    $row->setSourceProperty('hover_image', $images);

    // about_us
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_display_value
      FROM
        {field_data_field_useracct_display} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('about_us', $record->field_useracct_display_value );
    }
 
    // is_admin
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_libadmin_value
      FROM
        {field_data_field_useracct_libadmin} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('about_us', $record->field_useracct_libadmin_value );
    }

    // hover_image
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_animalimg_fid,
        fld.field_useracct_animalimg_alt,
        fld.field_useracct_animalimg_title,
        fld.field_useracct_animalimg_width,
        fld.field_useracct_animalimg_height
      FROM
        {field_data_field_useracct_animalimg} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    $images = [];
    foreach ($result as $record) {
      $images[] = [
        'target_id' => $record->field_useracct_animalimg_fid,
        'alt' => $record->field_useracct_animalimg_alt,
        'title' => $record->field_useracct_animalimg_title,
        'width' => $record->field_useracct_animalimg_width,
        'height' => $record->field_useracct_animalimg_height,
      ];
    }
    $row->setSourceProperty('animal_image', $images);

    // animal_text
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_animaltxt_value
      FROM
        {field_data_field_useracct_animaltxt} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('animal_text', $record->field_useracct_animaltxt_value );
    }

    // position_text
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_position_value
      FROM
        {field_data_field_useracct_position} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('position_text', $record->field_useracct_position_value );
    }

    // profile_link
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_biblioprofile_url,
        fld.field_useracct_biblioprofile_title,
        fld.field_useracct_biblioprofile_attributes
      FROM
        {field_data_field_useracct_biblioprofile} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    $links = [];
    foreach ($result as $record) {
      $links[] = [
        'uri' => $record->field_useracct_biblioprofile_url,
        'title' => $record->field_useracct_biblioprofile_title,
        'options' => $record->field_useracct_biblioprofile_attributes,
      ];
    }
    $row->setSourceProperty('profile_link', $links);

    // fun_fact
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_funfact_value
      FROM
        {field_data_field_useracct_funfact} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('fun_fact', $record->field_useracct_funfact_value );
    }

    // current_read_link
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_currentread_url,
        fld.field_useracct_currentread_title,
        fld.field_useracct_currentread_attributes
      FROM
        {field_data_field_useracct_currentread} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    $links = [];
    foreach ($result as $record) {
      $links[] = [
        'uri' => $record->field_useracct_currentread_url,
        'title' => $record->field_useracct_currentread_title,
        'options' => $record->field_useracct_currentread_attributes,
      ];
    }
    $row->setSourceProperty('current_read_link', $links);

    // favorite_read_link
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_faveread_url,
        fld.field_useracct_faveread_title,
        fld.field_useracct_faveread_attributes
      FROM
        {field_data_field_useracct_faveread} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    $links = [];
    foreach ($result as $record) {
      $links[] = [
        'uri' => $record->field_useracct_faveread_url,
        'title' => $record->field_useracct_faveread_title,
        'options' => $record->field_useracct_faveread_attributes,
      ];
    }
    $row->setSourceProperty('favorite_read_link', $links);

    // location will be handled by a separate plugin b/c need to convert from tid to entityid
    // department is handled by the builtin taxonomy plugin

    // manager_type
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_branchmanager_value
      FROM
        {field_data_field_useracct_branchmanager} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('manager_type', $record->field_useracct_branchmanager_value );
    }

    // user_phone
    $result = $this->getDatabase()->query('
      SELECT
        fld.field_useracct_phone_value
      FROM
        {field_data_field_useracct_phone} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($result as $record) {
      $row->setSourceProperty('user_phone', $record->field_useracct_phone_value );
    }


    return parent::prepareRow($row);
  }
 
  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'uid' => array(
        'type' => 'integer',
        'alias' => 'u',
      ),
    );
  }
 
  /**
   * Returns the user base fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function baseFields() {
    $fields = array(
      'uid' => $this->t('User ID'),
      'name' => $this->t('Username'),
      'pass' => $this->t('Password'),
      'mail' => $this->t('Email address'),
      'signature' => $this->t('Signature'),
      'signature_format' => $this->t('Signature format'),
      'created' => $this->t('Registered timestamp'),
      'access' => $this->t('Last access timestamp'),
      'login' => $this->t('Last login timestamp'),
      'status' => $this->t('Status'),
      'timezone' => $this->t('Timezone'),
      'language' => $this->t('Language'),
      'picture' => $this->t('Picture'),
      'init' => $this->t('Init'),
    );
    return $fields;
 
}
 
  /**
   * {@inheritdoc}
   */
  public function bundleMigrationRequired() {
    return FALSE;
  }
 
  /**
   * {@inheritdoc}
   */
  public function entityTypeId() {
    return 'user';
  }
 
}
?>