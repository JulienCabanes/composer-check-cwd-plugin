<?php
use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PreFileDownloadEvent;


class CheckCwdPlugin implements PluginInterface
{
  protected $composer;
  protected $io;
  
  public function activate(Composer $composer, IOInterface $io)
  { 
    $this->composer = $composer;
    $this->io = $io;
    
    $cwd = getcwd();
    $composer_json_path = $cwd.'/composer.json';
    $composer_json = [];
    
    if(is_file($composer_json_path)) {
      $composer_json = json_decode(file_get_contents($composer_json_path), true);
    }
    
    if(count($composer_json) <= 0) {
      $spc = str_repeat(' ', strlen($cwd));
      $io->writeError([
        '',
        '<warning>                                '.$spc.'  </warning>',
        '<warning>  There are no composer.json in '.$cwd.'  </warning>',
        '<warning>                                '.$spc.'  </warning>',
        ''
      ]);
    }
  }
}