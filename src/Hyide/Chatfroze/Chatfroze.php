<?php

namespace Hyide\Chatfroze;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerChatEvent;

class Chatfroze extends PluginBase implements Listener{
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir ($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [ 
            "mode" => "false" ]);
        $this->db = $this->config->getAll();
    }
    public function onChat(PlayerChatEvent $event) {
        if ($this->db["mode"] === true) {
            $event->setCancelled(true);
            $event->getPlayer()->sendMessage ("ä���� ������");
        } else {
            $event->setCancelled(false);
        }
    }
         public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
             if ($command->getName() === "ä��") {
                 if (!$sender->isOp()) {
                     $sender->sendMessage ("�۹̼��� ���");
                     return true;
                 }
                 if (! isset ($args[0])) {
                     $sender->sendMessage ("/ä�� <�󸮱�/���̱�>");
                     return true;
                 }
                 if ($args[0] === "�󸮱�") {
                     $this->db["mode"] = true;
                     $this->save();
                     $this->getServer()->broadcastMessage("ä���� ������ɽÿ�");
                    
                 }
                 if ($args[0] === "���̱�") {
                     $this->db["mode"] = false;
                     $this->save();
                     $this->getServer()->broadcastMessage("ä���� �쿩���ɽÿ�");
                 }
             }
             return true;
         }
       
         public function save(){
             $this->config->setAll($this->db);
             $this->config->save();
         }
         public function onDisable() {
             $this->save();
         
             
         }
}
                                                        
                                                         
         

    
    
   
