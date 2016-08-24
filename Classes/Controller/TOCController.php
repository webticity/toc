<?php

namespace ONEANDONE\Toc\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides functionality to show a table of contents based on headlines in the current document
 *
 * @author Ulf Mayer
 */
class TOCController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

  protected $objectManager;
  
  private $extensionSettings;
  
  /**
   * tocRepository
   *
   * @var \ONEANDONE\Toc\Domain\Repository\TOCRepository
   * @inject
   */
  protected $tocRepository = NULL;   

  const extKey = 'toc';

  public function __construct() {
    parent::__construct();
    $settings = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][self::extKey]);
    $extensionSettings = is_array($settings) ? $settings : array();
    $this->extensionSettings = $extensionSettings;
  }

  /**
   * action show
   * 
   */
  public function showAction() {
    $toc = $this->tocRepository;  
    if (!empty($toc)) {
      /* Pass extension settings to repository */
      $toc = $toc->find($this->extensionSettings);
      if (!empty($toc)) {
        $this->view->assignMultiple(Array(
            'toc' => $toc,
            'settings' => $this->extensionSettings
        ));
        $content = $this->view->render();
        return $content;
      }
    }

  }
}
