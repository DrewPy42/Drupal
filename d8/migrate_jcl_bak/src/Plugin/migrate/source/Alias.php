<?php
/**
 * @file
 * Contains \Drupal\my_module\Plugin\migrate\source\Node.
 */
 
namespace Drupal\migrate_jcl\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\node\Plugin\migrate\source\d7\Node as D7Node;
use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;


/**
 * Custom node source including url aliases.
 *
 * @MigrateSource(
 *   id = "migrate_jcl_alias"
 * )
 */
class NodeAlias extends D7Node {

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return ['alias' => $this->t('Path alias')] + parent::fields();
  }

/**
 * {@inheritdoc}
 */
public function prepareRow(Row $row) {
  // Include path alias.
  $nid = $row->getSourceProperty('nid');
  $query = $this->select('url_alias', 'ua')
                ->fields('ua', ['alias']);
  $query->condition('ua.source', 'node/' . $nid);
  $alias = $query->execute()->fetchField();
  if (!empty($alias)) {
    $row->setSourceProperty('alias', '/' . $alias);
  }
  return parent::prepareRow($row);
} 