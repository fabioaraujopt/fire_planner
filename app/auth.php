<?php


class Auth{
    
    #return
    #user_id (if exists)
    #null (if not exists)
    public static function getMember($db,$email,$password )
    {
        try {
            $query=$db->prepare('SELECT user_id FROM users where email=:email and password=:password ');
            $query->execute([':email' => $email, ':password' => $password]);
        }catch(Exception $e) {
            return false;
        }
        return $query->fetch(PDO::FETCH_ASSOC)['user_id'];
        
            
    }
    
}