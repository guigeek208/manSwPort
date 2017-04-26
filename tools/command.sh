#!/bin/bash
# Maintainer Guillaume Roche groche@guigeek.org
#

DIR=$(dirname $0)
HOSTS_FILE=$DIR"/host.txt"
usage() {
    echo -en "Usage:\t$1 <host> <login> <password> <enablepassword> <up|down|status>\nContact: <groche@guigeek.org>\n"
}

do_cmd() {
    echo $host
    res=-1
    proto=0
    res=$(nc -vnz -w 5 $host 22 >/dev/null 2>/dev/null; echo $?)
    if [[ "$res" == "0" ]]; then
        proto="ssh"
        #echo "$DIR/ssh.expect $host $login $pass $enablepassword $port $cmd"
        $DIR/ssh.expect $host $login $pass $enablepassword $port $cmd
    else
        res=$(nc -vnz -w 5 $host 23 >/dev/null 2>/dev/null; echo $?)
        if [[ "$res" == "0" ]]; then
            proto="telnet"
            $DIR/telnet.expect $host $login $pass $enablepassword $port $cmd
            #$DIR/telnet.pl $host $login $pass $enablepassword $port $cmd
        fi
    fi
}

#times=3
host=$1
login=$2
pass=$3
enablepassword=$4
cmd=$5
do_cmd

