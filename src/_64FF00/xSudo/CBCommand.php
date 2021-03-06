<?php

namespace _64FF00\xSudo;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;

use pocketmine\Player;

use pocketmine\utils\TextFormat;

class CBCommand extends Command implements PluginIdentifiableCommand
{
	public function __construct(xSudo $plugin, $name, $description)
	{
		$this->plugin = $plugin;
		parent::__construct($name, $description);
	}
	
	private function checkPermission(CommandSender $sender){
		if(!($sender->isOp() or $sender->hasPermission("pp.all"))){
			$sender->sendMessage(TextFormat::RED . "You don't have permission to use this command.");
			return false;
		}
		return true;
	}
	
	public function execute(CommandSender $sender, $label, array $args)
	{
		if(!isset($args[0]) or !isset($args[1]))
		{
			if(!$this->checkPermission($sender)) return true;
			$sender->sendMessage(TextFormat::GREEN . "[PlayerPrivacy] Usage: /cb <add|remove> <player>");
			return false;
		}
		$player=$this->plugin->getServer()->getPlayer($args[1]);
		if($player==null){
			$player=$args[1];
		}else{
			$player=$player->getName();
		}
		$player=strtolower($player);
		switch($args[0]){
			case "add":
				$this->plugin->chatBlock=array_merge($this->plugin->chatBlock,array($player=>1));
				$sender->sendMessage(TextFormat::GREEN."Added ".$player." into Chat Block List.");
				break;
			case "remove":
				$this->plugin->chatBlock=array_diff_key($this->plugin->chatBlock,array($player=>1));
				$sender->sendMessage(TextFormat::GREEN."Removed ".$player." from Chat Block List.");
				break;
		}
		return true;
	}

	public function getPlugin(){
		return $this->plugin;
	}
}