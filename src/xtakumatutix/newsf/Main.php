<?php

namespace xtakumatutix\newsf;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use RuinPray\ui\UI;
use RuinPray\ui\forms\SimpleForm;

Class Main extends PluginBase implements Listener {

    public function onEnable(){
        $this->getLogger()->notice("読み込み完了_ver.1.0.0");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->AlreadyRead = new Config($this->getDataFolder() . "AlreadyRead.yml", Config::YAML);
        $this->News = new Config($this->getDataFolder() . "News.yml", Config::YAML, array(
            'ニュース' => 'Hello World{br}改行だよ＞＜',
        ));
    }

	public function onJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$name = $player->getName();
		if(!$this->AlreadyRead->get($name) == null) {
		}else{
		    $this->AlreadyRead->set($name);
            $this->AlreadyRead->save();
		    $this->sendUI($player);
		}
        return true;
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args):bool{
		if ($sender instanceof Player) {
    		$player = $sender;
    	    $this->sendUI($player);
    	} else {

    	}
    	return true;
    }

    public function sendUI(Player $player): void{
    $message =$this->News->get("ニュース");
    $message = str_replace("{br}", "\n", $message);
    $form = UI::createSimpleForm(100);
    $form->setTitle("News");
    $form->setContent("".$message."");
    $form->addButton("§c閉じる");
    UI::sendForm($player, $form);
  }
}