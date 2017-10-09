<?php
 
namespace Drupal\migrate_jcl\Plugin\migrate\source;
 
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
 
/**
 * Convert a date field to the proper format.
 *
 * @MigrateProcessPlugin(
 *   id = "fix_date_no_time"
 * )
 */
class FixDateNoTime extends ProcessPluginBase {

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
        $date = new \DateTime();
        $date->setTimestamp($value);
      }
      elseif (is_array($value)) {
        $value = implode(',', $value);
        $date = new \DateTime($value);
      }
      else {
        $date = new \DateTime($value);
      }
      $value = $date->format('Y-m-d');
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid source date.');
    }
    return $value;
  }
}