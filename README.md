# Manage Port
## web interface for manage and enable/disable switch ports

Requirements
------------
php5-mcrypt
telnet
expect

Authentication
------------
default password : admin


Config/conf.json
------------

```
{
    "site": [
        {
            "nom": "EcoleMondercange",
            "salles": [
                {
                    "nom": "Salle1",
                    "hosts": [
                        {
                            "nom": "SW01",
                            "ip": "10.255.1.203",
                            "devices": [
                                {
                                    "nom": "AP01",
                                    "couverture": "Salle du 1er et couloir",
                                    "port": "Gi0/1"
                                }
                            ]
                        },
                        {
                            "nom": "SW02",
                            "ip": "10.255.1.104",
                            "devices": [
                                {
                                    "nom": "AP02",
                                    "couverture": "Hall d'entrée et blablablza",
                                    "port": "Gi0/1"
                                }, 
                                {
                                    "nom": "AP03",
                                    "couverture": "Cave et Gymnase",
                                    "port": "Gi0/2"
                                },
                                {
                                    "nom": "TELGWEN",
                                    "couverture": "Téléphone Gwenael",
                                    "port": "Gi0/3"
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
```

Author Information
------------------

Guillaume Roche
