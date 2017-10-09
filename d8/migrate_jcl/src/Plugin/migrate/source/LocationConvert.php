<?php
/**
 * @file
 * Contains \Drupal\migrate_jcl\Plugin\migrate\source\LocationConvert.
 */
 
namespace Drupal\migrate_jcl\Plugin\migrate\source;
 
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Convert location taxonomy fields to location reference fields
 *
 * @MigrateProcessPlugin(
 *   id = "location_convert"
 * )
 */
class LocationRef extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    $this->configuration = $configuration;
    $this->pluginId = $plugin_id;
    $this->pluginDefinition = $plugin_definition;
  }

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    try {
      if (is_numeric($value)) {
        $nid = getNidFromTid($value);
      }
      else {
        $nid = getNidFromName($value); 
      }
      $value = $nid
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid source location value.');
    }
    return $value;
  }
}

function getNidFromTid($tid) {
  $result = $this->getDatabase()->query('
      SELECT
        td.name
      FROM
        {taxonomy_term_data} td
      WHERE
        td.tid = :id
    ', array(':id' => $tid));
    foreach ($result as $record) {
      $nid = getNidFromName($record->name);
    }
  return $nid;
}

function getNidFromTid($location_name) {
  $result = $this->getDatabase()->query('
      SELECT
        n.nid
      FROM
        {nodes} n
      WHERE
        n.title = :location_name
    ', array(':location_name' => $location_name));
    foreach ($result as $record) {
      $nid = $record->nid);
    }
  return $nid;
}

//   /**
//    * {@inheritdoc}
//    */
//   public function query() {
//     $query = $this->select('taxonomy_term_data', 'td')
//       ->fields('td', array('tid', 'vid', 'name', 'description', 'weight', 'format'))
//       ->condition('tid', $row->getSourceProperty('tid'))
//       ->distinct();
//     return $query;
//   }


//   /**
//    * {@inheritdoc}
//    */
//   public function fields() {
//     return array(
//       'nid' => $this->t('The ID of the location.'),
//     );
//   }


// /**
//    * {@inheritdoc}
//    */
//   public function prepareRow(Row $row) {
//     // get the location name from the tid value
//     $location_name = $row->getSourceProperty($this->configuration['name'];
//     $result = $this->getDatabase()->query('
//       SELECT
//         n.nid
//       FROM
//         {nodes} n
//       WHERE
//         n.title = :location_name
//     ', array(':location_name' => $location_name));
//     foreach ($result as $record) {
//       $row->setSourceProperty('target_id', $record->nid);
//     }
//      return parent::prepareRow($row);
//   }
//   /**
//    * {@inheritdoc}
//    */
//   public function getIds() {
//     $ids['tid']['type'] = 'integer';
//     return $ids;
//   }