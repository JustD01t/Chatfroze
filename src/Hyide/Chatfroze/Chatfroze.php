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
            $event->getPlayer()->sendMessage ("채팅이 얼려졌찌여");
        } else {
            $event->setCancelled(false);
        }
    }
         public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
             if ($command->getName() === "채팅") {
                 if (!$sender->isOp()) {
                     $sender->sendMessage ("퍼미션이 없찌여");
                     return true;
                 }
                 if (! isset ($args[0])) {
                     $sender->sendMessage ("/채팅 <얼리기/녹이기>");
                     return true;
                 }
                 if ($args[0] === "얼리기") {
                     $this->db["mode"] = true;
                     $this->save();
                     $this->getServer()->broadcastMessage("채팅이 얼려졌심시오");
                    
                 }
                 if ($args[0] === "녹이기") {
                     $this->db["mode"] = false;
                     $this->save();
                     $this->getServer()->broadcastMessage("채팅이 녹여졌심시오");
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
                                                        
                                                         
         

    
    
   
