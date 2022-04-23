<?php
///
/// Small script, if you do not know how to read it, you probably should not use it.
/// Although it cannot do much harm if you run it in an empty directory.
///


$data = explode(PHP_EOL,file_get_contents('/home/username/Putty_backup.reg'));
$entries = Array();

$counter = -1;
foreach($data as $line){
    // putty exports are in the wrong format I guess.
    $line3 = mb_convert_encoding($line,'ISO-8859-1',"UTF-16");
    // And has some weird characters at the end of the line.
    $line4 = substr($line3,0 , strlen($line3)-2);
    // replace back spaces
    $line2 = str_replace('%20',' ',$line4);

    if (str_contains($line2,'\\Sessions\\')){
        $session = substr($line2,10 + mb_strpos($line2,'\\Sessions\\'),strlen($line2)-(11 + mb_strpos($line2,'\\Sessions\\')));
        echo $session . PHP_EOL;
        $counter += 1;
        $entries[$counter] = new stdClass();
        $entries[$counter]->name = $session;
    }else{
        $line1 = str_replace('"','',(string) $line2);
        $a = explode("=",$line1);
        $name = (string) $a[0];
        if (isset($a[1])) {
            $prop = (string)$a[1];
        }else{
            $prop ='';
        }
        $values_to_find = array("UserName",'HostName');
        if (in_array($a[0],$values_to_find)){
            $entries[$counter]->$name = $prop;
        }
    }
}
// var_dump($entries);

// Print the data to files.
foreach($entries as $entrie) {
    $username = $entrie->UserName;
    $hostname = $entrie->HostName;
    $name =  $entrie->name;
    $Out_string = "
[remmina]
ssh_tunnel_loopback=0
ssh_tunnel_passphrase=
name=$name
password=
ssh_proxycommand=
ssh_passphrase=
run_line=
precommand=
sshlogenabled=0
ssh_tunnel_enabled=0
ssh_charset=
ssh_auth=3
ignore-tls-errors=1
postcommand=
server=$hostname
disablepasswordstoring=0
ssh_color_scheme=0
audiblebell=0
ssh_tunnel_username=
sshsavesession=0
ssh_hostkeytypes=
ssh_tunnel_password=
profile-lock=0
exec=
group=
ssh_tunnel_server=
ssh_ciphers=
enable-autostart=0
ssh_kex_algorithms=
ssh_compression=0
ssh_tunnel_auth=0
ssh_tunnel_certfile=
notes_text=
viewmode=4
sshlogname=
ssh_tunnel_privatekey=
protocol=SSH
ssh_stricthostkeycheck=0
username=$username

";
    $filename =  'group_ssh_' .str_replace(' ','_',$name)."_".str_replace(' ','_',$hostname) . '.remmina';
    file_put_contents($filename,$Out_string);
    echo $Out_string.PHP_EOL;
}





/*
// Unused piece of code to grab the stuff from a Remmina config file.
// maybe usefull to create an opposite file for Putty reg file.
$data = explode(PHP_EOL,file_get_contents('/home/username/.var/app/org.remmina.Remmina/data/remmina/group_ssh_name_host.remmina'));
$remmina_object = new stdClass();
foreach($data as $line){
    if (substr($line,0,1) !== "["){
        $a = explode("=",$line);
        if ($a[0] !=="") {
            $name = (string) $a[0];
            $prop = (string) $a[1];
            $remmina_object->$name = $prop;
        }
    }
}
*/