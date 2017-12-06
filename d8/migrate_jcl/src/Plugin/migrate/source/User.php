<?php
/**
 * @file
 * Contains \Drupal\migrate_custom\Plugin\migrate\source\User.
 */

namespace Drupal\migrate_jcl\Plugin\migrate\source;

use Drupal\migrate\MigrateException;
use Drupal\migrate\Row;
use Drupal\migrate\Plugin\migrate\source\SqlBase;


/**
 * Extract users from the JCL Drupal 7 database and migrates them to D8.
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
    $fields['user_phone'] = $this->t('Phone number');
    return $fields;
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

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $uid = $row->getSourceProperty('uid');
    // first_name
    $row->setSourceProperty('first_name',$this->getValueField('field_useracct_firstname', $uid));
    // last_name
    $row->setSourceProperty('last_name',$this->getValueField('field_useracct_lastname', $uid));
    // user_image
    $row->setSourceProperty('user_image',$this->getImageField('field_useracct_img', $uid));
    // hover_image
    $row->setSourceProperty('hover_image',$this->getImageField('field_useracct_hoverimg', $uid));
    // about_us
    $row->setSourceProperty('about_us',$this->getValueField('field_useracct_display', $uid));
    // is_admin
    $row->setSourceProperty('library_admin',$this->getValueField('field_useracct_libadmin', $uid));
    // animal_image
    $row->setSourceProperty('animal_image',$this->getImageField('field_useracct_animalimg', $uid));
    // animal_text
    $row->setSourceProperty('animal_text',$this->getValueField('field_useracct_animaltxt', $uid));
    // position_text
    $row->setSourceProperty('position_text',$this->getValueField('field_useracct_position', $uid));
    // profile_link
    $row->setSourceProperty('profile_link',$this->getLinkField('field_useracct_biblioprofile', $uid));
    // fun_fact
    $row->setSourceProperty('fun_fact',$this->getValueField('field_useracct_funfact', $uid));
    // current_read_link
    $row->setSourceProperty('current_read_link',$this->getLinkField('field_useracct_currentread', $uid));
    // favorite_read_link
    $row->setSourceProperty('favorite_read_link',$this->getLinkField('field_useracct_currentread', $uid));
    // location
    $row->setSourceProperty('location',$this->getIDValueField('field_useracct_locnoderef', $uid));
    // department is handled by the builtin taxonomy plugin
    // manager_type
    $row->setSourceProperty('manager_type',$this->getValueField('field_useracct_branchmanager', $uid));
    // user_phone
    $row->setSourceProperty('user_phone',$this->getValueField('field_useracct_phone', $uid));

    return parent::prepareRow($row);
  }



  /**
   * get the value of a text/numeric field
   * @return string
   *
   */
  public function getValueField($srcfield, $uid) {
    $value_field = $srcfield . '_value';
    try {
      $records = $this->getDatabase()->query('
        SELECT
          fld.' . $value_field .'
        FROM
          {field_data_' . $srcfield . '} fld
        WHERE
          fld.entity_id = :uid
      ', array(':uid' => $uid));
      foreach ($records as $record) {
        $value = $record->$value_field;
      }
      return $value;
    }
    catch (\Exception $e) {
      throw new MigrateException($e);
    }
}

/**
 * get the value of a text/numeric field
 * @return integer
 *
 */
public function getIDValueField($srcfield, $uid) {

  $id_value_field = $srcfield . '_target_id';
  try {
    $records = $this->getDatabase()->query('
      SELECT
        fld.' . $id_value_field .'
      FROM
        {field_data_' . $srcfield . '} fld
      WHERE
        fld.entity_id = :uid
    ', array(':uid' => $uid));
    foreach ($records as $record) {
      $value = $record->$id_value_field;
    }
    return $value;
  }
  catch (\Exception $e) {
    throw new MigrateException($e);
  }
}
  /**
   * get the fields for a image field
   * @return array
   *
   */
  public function getImageField($srcfield, $uid) {
    try {
      $records = $this->getDatabase()->query('
        SELECT
          fld.' . $srcfield . '_fid as fid,
          fld.' . $srcfield . '_alt as alt,
          fld.' . $srcfield . '_title as title,
          fld.' . $srcfield . '_width as width,
          fld.' . $srcfield . '_height as height
        FROM
          {field_data_' . $srcfield . '} fld
        WHERE
          fld.entity_id = :uid
      ', array(':uid' => $uid));
      $images = [];
      foreach ($records as $record) {
        $images[] = [
          'target_id' => $record->fid,
          'alt' => $record->alt,
          'title' => $record->title,
          'width' => $record->width,
          'height' => $record->height,
        ];
      }
      return $images;
    }
    catch (\Exception $e) {
      throw new MigrateException('Error retrieving User image field data.');
    }
}

  /**
   * get the link field data
   * @return array
   *
   */
  public function getLinkField($srcfield, $uid) {
    try {
      $records = $this->getDatabase()->query('
        SELECT
          fld.' . $srcfield . '_url as url,
          fld.' . $srcfield . '_title as title,
          fld.' . $srcfield . '_attributes as attributes
        FROM
          {field_data_' . $srcfield . '} fld
        WHERE
          fld.entity_id = :uid
      ', array(':uid' => $uid));
      $links = [];
      foreach ($records as $record) {
        $links[] = [
          'uri' => $record->url,
          'title' => $record->title,
          'options' => $record->attributes,
        ];
      }
      return $links;
    }
    catch (\Exception $e) {
      throw new MigrateException('Error retrieving User link field data.');
    }
  }
}
?>
