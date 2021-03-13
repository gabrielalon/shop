<?php

return [
    'navbar' => [
        'brand' => 'NetTech',
        'dashboard' => 'Dashboard',
        'account' => [
            'submenu' => 'Konta',
            'admin' => 'Administratorzy',
        ],
        'b2b' => [
            'contractor' => 'Firmy',
            'submenu' => 'B2B',
            'project' => 'Projekty',
            'ticket' => 'Zadania',
        ],
        'content' => [
            'submenu' => 'Treści',
            'blog' => [
                'category' => 'Kategorie bloga',
                'entry' => 'Wpisy bloga',
            ],
        ],
    ],

    'account' => [
        'logo' => 'Avatar',
        'manage' => 'Akcje',
        'details' => 'Szczegóły',
        'full_name' => 'Imię i nazwisko',
        'email' => 'Email',
        'role' => 'Odpowiedzialność',
        'dashboard' => [
            'header' => 'Dashboard',
        ],
        'index' => [
            'header' => 'Konta',
            'manage' => 'Zarządzaj kontami',
        ],
        'profile' => 'Profil',
        'login' => 'Zaloguj',
        'logout' => 'Wyloguj',

        'action' => [
            'avatar_change' => 'Dostosuj avatar',
            'password_reset' => 'Zresetuj hasło',
            'data_update' => 'Dane ogólne',
            'add_account' => 'Dodaj administratora',
        ],
    ],

    'b2b' => [
        'contractor' => [
            'details' => 'Szczegóły',
            'home' => 'Firma',
            'manage' => 'Akcje',
            'name' => 'Nazwa',
            'project_count' => 'Liczba projektów',
            'index' => [
                'header' => 'Firmy',
                'manage' => 'Zarządzaj firmami',
            ],
            'action' => [
                'new' => 'Dodaj firmę',
                'new_address' => 'Nowy adres',
                'edit_address' => 'Edytuj adres',
                'edit' => 'Edytuj firmę',
                'remove' => 'Usuń firmę',
                'address' => 'Adresy',
                'project' => 'Projekty',
                'customer' => 'Klienci',
                'nip' => 'Pobierz z GUS'
            ],
            'form' => [
                'label' => [
                    'name' => 'Nazwa',
                    'tax_number' => 'NIP',
                    'street_name' => 'Ulica',
                    'building_number' => 'Numer domu',
                    'apartment_number' => 'Numer lokalu',
                    'country_code' => 'Kraj',
                    'city' => 'Miasto',
                    'postal_code' => 'Kod pocztowy',
                    'latitude' => 'lat',
                    'longitude' => 'lng',
                ],
            ],
        ],
        'project' => [
            'manage' => 'Akcje',
            'name' => 'Nazwa',
            'ticket_count' => 'Liczba zadań',
            'note' => 'Notatki',
            'index' => [
                'header' => 'Projekty',
                'manage' => 'Zarządzaj projektami',
            ],
            'action' => [
                'new' => 'Dodaj projekt',
                'edit' => 'Edytuj projekt',
                'activate' => 'Aktywuj projekt',
                'deactivate' => 'Deaktywuj projekt',
                'remove' => 'Usuń projekt',
            ],
            'form' => [
                'label' => [
                    'name' => 'Nazwa',
                    'note' => 'Notatki',
                ],
            ],
        ],
        'ticket' => [
            'manage' => 'Akcje',
            'name' => 'Nazwa',
            'project_name' => 'Projekt',
            'comment' => 'Komentarze',
            'comment_count' => 'Liczba komentarzy',
            'content' => 'Treść',
            'status' => 'Status',
            'type' => 'Typ',
            'index' => [
                'header' => 'Zadania',
                'manage' => 'Zarządzaj zadaniami',
            ],
            'action' => [
                'new' => 'Dodaj zadanie',
                'new_comment' => 'Dodaj komentarz',
                'edit' => 'Edytuj zadanie',
                'activate' => 'Aktywuj zadanie',
                'deactivate' => 'Deaktywuj zadanie',
                'remove' => 'Usuń zadanie',
            ],
            'form' => [
                'label' => [
                    'name' => 'Nazwa',
                    'content' => 'Treść',
                    'status' => 'Status',
                    'type' => 'Typ',
                ],
            ],
            'statuses' => [
                'new' => 'Nowe',
                'progress' => 'W realizacji',
                'finish' => 'Zakończone',
            ],
            'types' => [
                'bug' => 'Błąd',
                'support' => 'Wsparcie',
                'feature' => 'Rozwiązanie',
            ],
        ],
    ],

    'content' => [
        'blog' => [
            'category' => [
                'manage' => 'Akcje',
                'name' => 'Nazwa',
                'index' => [
                    'header' => 'Kategorie bloga',
                    'manage' => 'Zarządzaj kategoriami',
                ],
                'action' => [
                    'new' => 'Dodaj kategorię',
                    'edit' => 'Edytuj kategorię',
                    'activate' => 'Aktywuj kategorię',
                    'deactivate' => 'Deaktywuj kategorię',
                    'remove' => 'Usuń kategorię',
                ],
                'form' => [
                    'label' => [
                        'name' => 'Nazwa',
                    ],
                ],
            ],
            'entry' => [
                'manage' => 'Akcje',
                'name' => 'Nazwa',
                'publish_at' => 'Data publikacji',
                'index' => [
                    'header' => 'Wpisy bloga',
                    'manage' => 'Zarządzaj wpisami',
                ],
                'action' => [
                    'new' => 'Dodaj wpis',
                    'edit' => 'Edytuj wpis',
                    'activate' => 'Aktywuj wpis',
                    'deactivate' => 'Deaktywuj wpis',
                    'remove' => 'Usuń wpis',
                ],
                'form' => [
                    'label' => [
                        'name' => 'Nazwa',
                        'description' => 'Treść',
                        'publish_at' => 'Data publikacji',
                        'categories_id' => 'Kategorie',
                    ],
                ],
            ],
        ],
    ],

    'dashboard' => [
        'total_users' => 'Liczba użytkowników',
    ],
];
