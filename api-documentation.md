# Schedule Application API Documentation

## Overview

This document serves as a comprehensive reference for the Schedule application's API structure, data interfaces, and page functionalities. It will be used to guide development and ensure consistency across the application.

This is a multi-tenant application where users are associated with specific teams/organizations.

## API Base URL

```
http://127.0.0.1:8000/api/
```

## Authentication

### Login

**Endpoint:** `POST /auth/login`

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login success.",
    "token": "2|uUy6hRgtgbFaSx534CHyRphq3S4l8R3BpmX2uAf4c2cfad15"
}

```

### Current User

**Endpoint:** `GET /user`

**Response:**
```json
{
    "id": "01jvdvd9kxg21gcp2wvc1jcnsv",
    "name": "Company Admin",
    "email": "companyadmin@example.com",
    "phone_number": "1234567892",
    "is_active": true,
    "roles": ["company_admin"],
    "team_id": "01JVDVD8RPWE3DW4QEN781CKXX"
}
```

### Logout

**Endpoint:** `POST /auth/logout`

**Response:**
```json
{
  "success": true,
  "message": "Successfully logged out"
}
```

## Data Structures & Endpoints

### User

```typescript
interface User {
  id: number;
  name: string;
  email: string;
  phone_number: string;
  role: ['worker' | 'admin' | 'company_admin', 'super_admin'];
  team_id: number;
  avatar_url?: string;
  createdAt: string;
  updatedAt: string;
}
```
### Dashboard Calendar

**Endpoint:** `GET api/v1/worker/calendar`

**Request:**
```json
{
  "from": "date",
  "to": "date"
}
```

**Response:**
```json
{
    "2025-05-04": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-05": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-06": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-07": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-08": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-09": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-10": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-11": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-12": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-13": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-14": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-15": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-16": {
        "userShifts": [
            {
                "type": "shift",
                "id": "01jve1tcm8n9vbv25t5p2bta1c",
                "shift_id": "01jve1tckhx0wvr3xxns7fkp99",
                "schedule_id": "01jve1tcj0gmxhfynfq84gcrqv",
                "schedule_worker_notes": null,
                "schedule_admin_notes": null,
                "venue_id": "01jvdve26hj45wdj0gbaxc6vdm",
                "venue_name": "Venue #1",
                "title": "Audio Visual Specialist",
                "schedule_title": "Fuck",
                "can_punch": false,
                "can_bailout": false,
                "call_time": 30,
                "start_time": "2025-05-16T15:00:00.000000Z",
                "end_time": "2025-05-16T19:00:00.000000Z",
                "timePunches": [],
                "worker_notes": null,
                "admin_notes": null,
                "workers": [
                    {
                        "shift_id": "01jve1tckhx0wvr3xxns7fkp99",
                        "shift_name": "Audio Visual Specialist",
                        "start_time": "2025-05-16T15:00:00.000000Z",
                        "end_time": null,
                        "worker_count": 2,
                        "workers": [
                            {
                                "user_id": null,
                                "user_shift_id": "01jve1tcmkcx7gg53xsqmex7fw",
                                "name": null,
                                "avatar_url": null,
                                "phone_number": null,
                                "email": null,
                                "user_shift_status": null,
                                "shift_request_status": null
                            },
                            {
                                "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
                                "user_shift_id": "01jve1tcm8n9vbv25t5p2bta1c",
                                "name": "Company Admin",
                                "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                                "phone_number": "1234567892",
                                "email": "companyadmin@example.com",
                                "user_shift_status": null,
                                "shift_request_status": "confirmed"
                            }
                        ]
                    }
                ],
                "venue": {
                    "id": "01jvdve26hj45wdj0gbaxc6vdm",
                    "venue_name": "Venue #1",
                    "venue_type": [
                        "venue"
                    ],
                    "venue_color": "gray",
                    "venue_comment": "",
                    "address": "89941 Cassin Mission\nPort Shanonhaven, NY 01401-0070",
                    "latitude": "29.767544",
                    "longitude": "-95.362125"
                }
            }
        ],
        "availability": [],
        "timeOff": []
    },
    "2025-05-17": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-18": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250518",
                "title": "Available",
                "start": "2025-05-18T16:00:00-05:00",
                "end": "2025-05-18T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-19": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250519",
                "title": "Available",
                "start": "2025-05-19T16:00:00-05:00",
                "end": "2025-05-19T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-20": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250520",
                "title": "Available",
                "start": "2025-05-20T16:00:00-05:00",
                "end": "2025-05-20T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-21": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250521",
                "title": "Available",
                "start": "2025-05-21T16:00:00-05:00",
                "end": "2025-05-21T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-22": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250522",
                "title": "Available",
                "start": "2025-05-22T16:00:00-05:00",
                "end": "2025-05-22T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-23": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250523",
                "title": "Available",
                "start": "2025-05-23T16:00:00-05:00",
                "end": "2025-05-23T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-24": {
        "userShifts": [],
        "availability": [
            {
                "type": "availability",
                "id": "av_01jvjm3jynckfkcb6e1ep6zam1_20250524",
                "title": "Available",
                "start": "2025-05-24T16:00:00-05:00",
                "end": "2025-05-24T17:00:00-05:00"
            }
        ],
        "timeOff": [
            {
                "type": "timeOff",
                "id": "to_01jvjm46awwf8xwkxwx8jvgrn3",
                "title": "dump",
                "start": "2025-05-18T00:00:00-05:00",
                "end": "2025-05-24T00:00:00-05:00",
                "status": "approved"
            }
        ]
    },
    "2025-05-25": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-26": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-27": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-28": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-29": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-30": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-05-31": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    },
    "2025-06-01": {
        "userShifts": [],
        "availability": [],
        "timeOff": []
    }
}  
```

```typescript
//need to be redone with current api response
```

### MyShifts

**Endpoint:** `GET api/worker/{team}/schedule/my-shifts`

**Response:**
```json
{
    "data": [
        {
            "id": "01jt1qs90wkebebk1vp0dabmtm",
            "shift_id": "01jt1qs8z16rr42t7d0tyampxs",
            "schedule_id": "01jt1qs8fxvwjqwpdjv67g1wsb",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "Shift #3",
            "schedule_title": "Schedule #9",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-04-05T11:00:00.000000Z",
            "end_time": "2025-04-05T21:00:00.000000Z",
            "timePunches": [
                {
                    "id": "01jt1qs959ex7a8tdjd2mw5d99",
                    "punch_time": "2025-04-05T11:03:00.000000Z",
                    "type": "in",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 1
                },
                {
                    "id": "01jt1qs95m6xwn40yz3p4frdhh",
                    "punch_time": "2025-04-05T21:12:00.000000Z",
                    "type": "out",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 2
                }
            ],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt1qs8gwt1dp2ks052mjjs7a",
                    "shift_name": "Shift #1",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T17:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8gz0cna3baz6yzk3h1q",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8hcxvt7yjh1rc2azg56",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8j0m8rn0b990vwc0cn5",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8jewwm3xnxyb4bzvk9z",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8jvp2jgkyzrc0pff1vd",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8k77870qbnvpfexrh5v",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8kj91j32n12bf0zwyrc",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8rgkcqdgvtfegrzbcmb",
                    "shift_name": "Shift #2",
                    "start_time": "2025-04-05T20:00:00.000000Z",
                    "end_time": "2025-04-06T01:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8rjsn7qpg34g36nxm7a",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8rtgv524542dx63sq8f",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8s22s6dmzm2417hkqph",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8sanabtfd71xe0y9d91",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8sjkw4sp33xtrsdqfm4",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8szamzh49denm4yd1q6",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8t7ga2cfv7sr2dyzszj",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8z16rr42t7d0tyampxs",
                    "shift_name": "Shift #3",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T21:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8z3c4zfrad2a2fp46ps",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8zg1gwafg5ysgrcgzrn",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8zthwcevab66rpr558d",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs903zgz5k9mstf27qt23",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs90b3n7e89z7jp8c03ke",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs90k36zhy3xxj75r9hx3",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs90wkebebk1vp0dabmtm",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs95wbv1wx210p19x6rj4",
                    "shift_name": "Shift #4",
                    "start_time": "2025-04-05T18:00:00.000000Z",
                    "end_time": "2025-04-05T22:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs95yzesgmj45bfgyf81p",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs9663yxa0vfyzthskbn2",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs96eryx5jwfhm0hs3sjw",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs96pgteavfq70yses155",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs96ys4tav6aw8nkfqydq",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs97f290kkm8aj0eg6y88",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs97rtvaha949qh3jc1pd",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jt1qs8kj91j32n12bf0zwyrc",
            "shift_id": "01jt1qs8gwt1dp2ks052mjjs7a",
            "schedule_id": "01jt1qs8fxvwjqwpdjv67g1wsb",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "Shift #1",
            "schedule_title": "Schedule #9",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-04-05T11:00:00.000000Z",
            "end_time": "2025-04-05T17:00:00.000000Z",
            "timePunches": [
                {
                    "id": "01jt1qs8qy4j0a38v75ct2qjmf",
                    "punch_time": "2025-04-05T11:07:00.000000Z",
                    "type": "in",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 1
                },
                {
                    "id": "01jt1qs8r9gfd8vqp1dbhk8evj",
                    "punch_time": "2025-04-05T17:03:00.000000Z",
                    "type": "out",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 2
                }
            ],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt1qs8gwt1dp2ks052mjjs7a",
                    "shift_name": "Shift #1",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T17:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8gz0cna3baz6yzk3h1q",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8hcxvt7yjh1rc2azg56",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8j0m8rn0b990vwc0cn5",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8jewwm3xnxyb4bzvk9z",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8jvp2jgkyzrc0pff1vd",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8k77870qbnvpfexrh5v",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8kj91j32n12bf0zwyrc",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8rgkcqdgvtfegrzbcmb",
                    "shift_name": "Shift #2",
                    "start_time": "2025-04-05T20:00:00.000000Z",
                    "end_time": "2025-04-06T01:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8rjsn7qpg34g36nxm7a",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8rtgv524542dx63sq8f",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8s22s6dmzm2417hkqph",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8sanabtfd71xe0y9d91",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8sjkw4sp33xtrsdqfm4",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8szamzh49denm4yd1q6",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8t7ga2cfv7sr2dyzszj",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8z16rr42t7d0tyampxs",
                    "shift_name": "Shift #3",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T21:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8z3c4zfrad2a2fp46ps",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8zg1gwafg5ysgrcgzrn",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8zthwcevab66rpr558d",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs903zgz5k9mstf27qt23",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs90b3n7e89z7jp8c03ke",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs90k36zhy3xxj75r9hx3",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs90wkebebk1vp0dabmtm",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs95wbv1wx210p19x6rj4",
                    "shift_name": "Shift #4",
                    "start_time": "2025-04-05T18:00:00.000000Z",
                    "end_time": "2025-04-05T22:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs95yzesgmj45bfgyf81p",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs9663yxa0vfyzthskbn2",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs96eryx5jwfhm0hs3sjw",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs96pgteavfq70yses155",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs96ys4tav6aw8nkfqydq",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs97f290kkm8aj0eg6y88",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs97rtvaha949qh3jc1pd",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jt1qs97rtvaha949qh3jc1pd",
            "shift_id": "01jt1qs95wbv1wx210p19x6rj4",
            "schedule_id": "01jt1qs8fxvwjqwpdjv67g1wsb",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "Shift #4",
            "schedule_title": "Schedule #9",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-04-05T18:00:00.000000Z",
            "end_time": "2025-04-05T22:00:00.000000Z",
            "timePunches": [
                {
                    "id": "01jt1qs9c7ybs61x1w6frf34xx",
                    "punch_time": "2025-04-05T22:14:00.000000Z",
                    "type": "out",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 2
                },
                {
                    "id": "01jt1qs9bw1barwb62qga8g625",
                    "punch_time": "2025-04-05T18:12:00.000000Z",
                    "type": "in",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 1
                }
            ],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt1qs8gwt1dp2ks052mjjs7a",
                    "shift_name": "Shift #1",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T17:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8gz0cna3baz6yzk3h1q",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8hcxvt7yjh1rc2azg56",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8j0m8rn0b990vwc0cn5",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8jewwm3xnxyb4bzvk9z",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8jvp2jgkyzrc0pff1vd",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8k77870qbnvpfexrh5v",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8kj91j32n12bf0zwyrc",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8rgkcqdgvtfegrzbcmb",
                    "shift_name": "Shift #2",
                    "start_time": "2025-04-05T20:00:00.000000Z",
                    "end_time": "2025-04-06T01:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8rjsn7qpg34g36nxm7a",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8rtgv524542dx63sq8f",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8s22s6dmzm2417hkqph",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8sanabtfd71xe0y9d91",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8sjkw4sp33xtrsdqfm4",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8szamzh49denm4yd1q6",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8t7ga2cfv7sr2dyzszj",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8z16rr42t7d0tyampxs",
                    "shift_name": "Shift #3",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T21:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8z3c4zfrad2a2fp46ps",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8zg1gwafg5ysgrcgzrn",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8zthwcevab66rpr558d",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs903zgz5k9mstf27qt23",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs90b3n7e89z7jp8c03ke",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs90k36zhy3xxj75r9hx3",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs90wkebebk1vp0dabmtm",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs95wbv1wx210p19x6rj4",
                    "shift_name": "Shift #4",
                    "start_time": "2025-04-05T18:00:00.000000Z",
                    "end_time": "2025-04-05T22:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs95yzesgmj45bfgyf81p",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs9663yxa0vfyzthskbn2",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs96eryx5jwfhm0hs3sjw",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs96pgteavfq70yses155",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs96ys4tav6aw8nkfqydq",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs97f290kkm8aj0eg6y88",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs97rtvaha949qh3jc1pd",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jt1qs8t7ga2cfv7sr2dyzszj",
            "shift_id": "01jt1qs8rgkcqdgvtfegrzbcmb",
            "schedule_id": "01jt1qs8fxvwjqwpdjv67g1wsb",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "Shift #2",
            "schedule_title": "Schedule #9",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-04-05T20:00:00.000000Z",
            "end_time": "2025-04-06T01:00:00.000000Z",
            "timePunches": [
                {
                    "id": "01jt1qs8ydbmrdjmde1ev3tw41",
                    "punch_time": "2025-04-05T20:02:00.000000Z",
                    "type": "in",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 1
                },
                {
                    "id": "01jt1qs8ys9esyex6x8384pnwk",
                    "punch_time": "2025-04-06T01:04:00.000000Z",
                    "type": "out",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 2
                }
            ],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt1qs8gwt1dp2ks052mjjs7a",
                    "shift_name": "Shift #1",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T17:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8gz0cna3baz6yzk3h1q",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8hcxvt7yjh1rc2azg56",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8j0m8rn0b990vwc0cn5",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8jewwm3xnxyb4bzvk9z",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8jvp2jgkyzrc0pff1vd",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8k77870qbnvpfexrh5v",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8kj91j32n12bf0zwyrc",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8rgkcqdgvtfegrzbcmb",
                    "shift_name": "Shift #2",
                    "start_time": "2025-04-05T20:00:00.000000Z",
                    "end_time": "2025-04-06T01:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8rjsn7qpg34g36nxm7a",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8rtgv524542dx63sq8f",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8s22s6dmzm2417hkqph",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs8sanabtfd71xe0y9d91",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs8sjkw4sp33xtrsdqfm4",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs8szamzh49denm4yd1q6",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs8t7ga2cfv7sr2dyzszj",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs8z16rr42t7d0tyampxs",
                    "shift_name": "Shift #3",
                    "start_time": "2025-04-05T11:00:00.000000Z",
                    "end_time": "2025-04-05T21:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs8z3c4zfrad2a2fp46ps",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs8zg1gwafg5ysgrcgzrn",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs8zthwcevab66rpr558d",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs903zgz5k9mstf27qt23",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs90b3n7e89z7jp8c03ke",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs90k36zhy3xxj75r9hx3",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs90wkebebk1vp0dabmtm",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt1qs95wbv1wx210p19x6rj4",
                    "shift_name": "Shift #4",
                    "start_time": "2025-04-05T18:00:00.000000Z",
                    "end_time": "2025-04-05T22:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qs01nb7v6wmzm1mjz6f7s",
                            "user_shift_id": "01jt1qs95yzesgmj45bfgyf81p",
                            "name": "Velva Pfannerstill",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velva+Pfannerstill&color=000&background=EBF4FF",
                            "phone_number": "959-881-1282",
                            "email": "vquitzon@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypd7wfsdkbswev0vw9w",
                            "user_shift_id": "01jt1qs9663yxa0vfyzthskbn2",
                            "name": "Lilla Reilly",
                            "avatar_url": "https://ui-avatars.com/api/?name=Lilla+Reilly&color=000&background=EBF4FF",
                            "phone_number": "(719) 360-0402",
                            "email": "walker69@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzc5xbgcgb70v13zxw54",
                            "user_shift_id": "01jt1qs96eryx5jwfhm0hs3sjw",
                            "name": "Prof. Fernando Hodkiewicz V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Fernando+Hodkiewicz+V&color=000&background=EBF4FF",
                            "phone_number": "+1-414-223-6911",
                            "email": "zoconner@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryen1w0jj2kbft2x571r",
                            "user_shift_id": "01jt1qs96pgteavfq70yses155",
                            "name": "Brody Carter",
                            "avatar_url": "https://ui-avatars.com/api/?name=Brody+Carter&color=000&background=EBF4FF",
                            "phone_number": "775-205-4364",
                            "email": "ukshlerin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qs00r1zhp93y06r0dpzva",
                            "user_shift_id": "01jt1qs96ys4tav6aw8nkfqydq",
                            "name": "Mrs. Elsa Terry",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Elsa+Terry&color=000&background=EBF4FF",
                            "phone_number": "1-762-812-0518",
                            "email": "mgreenholt@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrzgkcrc8nejg0714cgmh",
                            "user_shift_id": "01jt1qs97f290kkm8aj0eg6y88",
                            "name": "Joyce Considine Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Joyce+Considine+Sr.&color=000&background=EBF4FF",
                            "phone_number": "984.366.9268",
                            "email": "johns.aidan@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs97rtvaha949qh3jc1pd",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jt2cwt5z1043gnsft8xjrj2z",
            "shift_id": "01jt2cwt50e6gxg3f2zp3hrj09",
            "schedule_id": "01jt2cwt3m8tq69b8rfc88t1z4",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "A/V Tech",
            "schedule_title": "713: Load Out",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-04-29T15:00:00.000000Z",
            "end_time": "2025-04-30T04:58:00.000000Z",
            "timePunches": [],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt2cwt50e6gxg3f2zp3hrj09",
                    "shift_name": "A/V Tech",
                    "start_time": "2025-04-29T15:00:00.000000Z",
                    "end_time": "2025-04-30T04:58:00.000000Z",
                    "worker_count": 1,
                    "workers": [
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt2cwt5z1043gnsft8xjrj2z",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jt79vzym9h1tkj9hsk8vpr2w",
            "shift_id": "01jt79vzxv6tjzwvv9yga346yh",
            "schedule_id": "01jt79vzvqpew0k3cpmh9ddq4m",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "Carpenter",
            "schedule_title": "Fuck",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-05-01T15:00:00.000000Z",
            "end_time": "2025-05-02T03:00:00.000000Z",
            "timePunches": [],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt79vzxv6tjzwvv9yga346yh",
                    "shift_name": "Carpenter",
                    "start_time": "2025-05-01T15:00:00.000000Z",
                    "end_time": "2025-05-02T03:00:00.000000Z",
                    "worker_count": 1,
                    "workers": [
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt79vzym9h1tkj9hsk8vpr2w",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jv57m8ejt628vsb8sx4kp770",
            "shift_id": "01jv57m8dwcdcvq8wt22bc5ayw",
            "schedule_id": "01jv57m8ca99nztrqqb7j2812x",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jv57emx3nf4k0saqcedfqc24",
            "venue_name": "Venue",
            "title": "TEST",
            "schedule_title": "Fuck",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-05-11T16:25:00.000000Z",
            "end_time": "2025-05-11T16:25:00.000000Z",
            "timePunches": [],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jv57m8dwcdcvq8wt22bc5ayw",
                    "shift_name": "TEST",
                    "start_time": "2025-05-11T16:25:00.000000Z",
                    "end_time": null,
                    "worker_count": 2,
                    "workers": [
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jv57m8ejt628vsb8sx4kp770",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryhayaytv9ht1ppvt0p7",
                            "user_shift_id": "01jv57m8ez8tewg300k6jdw45g",
                            "name": "Oren Bayer I",
                            "avatar_url": "https://ui-avatars.com/api/?name=Oren+Bayer+I&color=000&background=EBF4FF",
                            "phone_number": "1-480-243-6983",
                            "email": "lilla17@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jv57emx3nf4k0saqcedfqc24",
                "venue_name": "Venue",
                "venue_type": [
                    "Restaurant"
                ],
                "venue_color": "",
                "venue_comment": "",
                "address": "1234567890",
                "latitude": null,
                "longitude": null
            }
        },
        {
            "id": "01jv58d48j7bk7k4a3j09ghjvv",
            "shift_id": "01jv58d47gnpsvh91fskzjh3sr",
            "schedule_id": "01jv58d46cgf1kcezh50f8ed6g",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jv57emx3nf4k0saqcedfqc24",
            "venue_name": "Venue",
            "title": "TEST",
            "schedule_title": "test fg",
            "can_punch": false,
            "can_bailout": false,
            "call_time": 30,
            "start_time": "2025-05-13T16:25:00.000000Z",
            "end_time": "2025-05-13T16:25:00.000000Z",
            "timePunches": [],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jv58d47gnpsvh91fskzjh3sr",
                    "shift_name": "TEST",
                    "start_time": "2025-05-13T16:25:00.000000Z",
                    "end_time": null,
                    "worker_count": 1,
                    "workers": [
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jv58d48j7bk7k4a3j09ghjvv",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jv57emx3nf4k0saqcedfqc24",
                "venue_name": "Venue",
                "venue_type": [
                    "Restaurant"
                ],
                "venue_color": "",
                "venue_comment": "",
                "address": "1234567890",
                "latitude": null,
                "longitude": null
            }
        },
        {
            "id": "01jt1qs6vgz7c8c0rnqt4xess1",
            "shift_id": "01jt1qs6schbxfpnt5q8qjj8j4",
            "schedule_id": "01jt1qs6rnyymzy45thhxvyd39",
            "schedule_worker_notes": "***EVENT NOTES***",
            "schedule_admin_notes": null,
            "venue_id": "01jt1qs2e35ydspnj2m8m9c2j2",
            "venue_name": "Venue #1",
            "title": "Shift #1",
            "schedule_title": "Schedule #5",
            "can_punch": false,
            "can_bailout": true,
            "call_time": 30,
            "start_time": "2025-06-17T18:00:00.000000Z",
            "end_time": "2025-06-18T07:00:00.000000Z",
            "timePunches": [
                {
                    "id": "01jt1qs6yrpz5xgagb1zqt54tk",
                    "punch_time": "2025-06-17T18:09:00.000000Z",
                    "type": "in",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 1
                },
                {
                    "id": "01jt1qs6z8w7gaksv7q6v9d15x",
                    "punch_time": "2025-06-18T07:07:00.000000Z",
                    "type": "out",
                    "reason": null,
                    "latitude": null,
                    "longitude": null,
                    "approved": false,
                    "order_column": 2
                }
            ],
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jt1qs6schbxfpnt5q8qjj8j4",
                    "shift_name": "Shift #1",
                    "start_time": "2025-06-17T18:00:00.000000Z",
                    "end_time": "2025-06-18T07:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jt1qryg0pm2xcjsgh3xz3ts4",
                            "user_shift_id": "01jt1qs6sfmpcp2jfpgqdbfva9",
                            "name": "Theresa Bradtke",
                            "avatar_url": "https://ui-avatars.com/api/?name=Theresa+Bradtke&color=000&background=EBF4FF",
                            "phone_number": "1-502-894-7209",
                            "email": "mgrimes@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrymcex7bncp4n0bf5s3m",
                            "user_shift_id": "01jt1qs6ss417qx9azwf2mn7a1",
                            "name": "Ethel Denesik",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ethel+Denesik&color=000&background=EBF4FF",
                            "phone_number": "1-276-705-4549",
                            "email": "dheller@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrze6nd8f2y00rywfxn67",
                            "user_shift_id": "01jt1qs6t3strt3h4ank3ha8zj",
                            "name": "Miss Kathlyn Lynch III",
                            "avatar_url": "https://ui-avatars.com/api/?name=Miss+Kathlyn+Lynch+III&color=000&background=EBF4FF",
                            "phone_number": "(272) 759-2913",
                            "email": "chadd.turner@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jt1qrzf9w66vgeww6198q1z7",
                            "user_shift_id": "01jt1qs6tkrghknahgdjzxqkcq",
                            "name": "Geo Koss",
                            "avatar_url": "https://ui-avatars.com/api/?name=Geo+Koss&color=000&background=EBF4FF",
                            "phone_number": "256.387.6044",
                            "email": "norene.jacobi@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrypy34353zaycmg58gv1",
                            "user_shift_id": "01jt1qs6twrgqjbpzkeqfzppqm",
                            "name": "Ms. Kattie Parker V",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ms.+Kattie+Parker+V&color=000&background=EBF4FF",
                            "phone_number": "(615) 434-4402",
                            "email": "gorczany.yasmeen@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qrz9pngwky5j9gdy6dxvp",
                            "user_shift_id": "01jt1qs6v3trxr76v6gtap7pjw",
                            "name": "Mrs. Dayna Rosenbaum II",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mrs.+Dayna+Rosenbaum+II&color=000&background=EBF4FF",
                            "phone_number": "(234) 838-0933",
                            "email": "mae.bailey@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt1qs6vgz7c8c0rnqt4xess1",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jt69x8s5mshy8m8t2cdctdxq",
                    "shift_name": "Carpenter",
                    "start_time": "2025-06-17T05:00:00.000000Z",
                    "end_time": null,
                    "worker_count": 3,
                    "workers": [
                        {
                            "user_id": "01jt1qrza5agmaekxm2g3dpar1",
                            "user_shift_id": "01jt69x8t285c881rhawqve2gs",
                            "name": "Athena Bechtelar MD",
                            "avatar_url": "https://ui-avatars.com/api/?name=Athena+Bechtelar+MD&color=000&background=EBF4FF",
                            "phone_number": "1-415-771-6631",
                            "email": "gleason.nayeli@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jt1qryhrmqvyhq45ga2nkw0k",
                            "user_shift_id": "01jt69x8sjhc4f9jwakf7d2cd0",
                            "name": "Celine Gusikowski",
                            "avatar_url": "https://ui-avatars.com/api/?name=Celine+Gusikowski&color=000&background=EBF4FF",
                            "phone_number": "779-558-4558",
                            "email": "ijast@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jt1qrwvae3asxftfw575sdgn",
                            "user_shift_id": "01jt6zrc6y6nktx1zsqbazvtez",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jt1qs2e35ydspnj2m8m9c2j2",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "blue",
                "venue_comment": "",
                "address": "204 Alvina Drive Suite 633\nLake Arvillachester, WA 53166",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/my-shifts?page=1",
        "last": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/my-shifts?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/my-shifts?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/my-shifts",
        "per_page": 15,
        "to": 9,
        "total": 9
    }
}
```

```typescript
//need to be redone with current api response
```

### AvailableShifts

**Endpoint:** `GET api/worker/{team}/schedule/available-shifts`

**Response:**
```json
{
    "data": [
        {
            "id": "01jvzjvp6tv0d4s0ws19q9y8qe",
            "shiftRequest_id": null,
            "shift_id": "01jvzhdzh68x5msv2rztb6we76",
            "schedule_id": "01jvzhdzghe16c6p2sajp18c2n",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jvzhdvm62ksknd5j3fsk4396",
            "venue_name": "Venue #1",
            "title": "Shift #1",
            "schedule_title": "Schedule #7",
            "call_time": 30,
            "start_time": "2025-05-26T16:00:00.000000Z",
            "end_time": "2025-05-26T21:00:00.000000Z",
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jvzhdznph16sc3c24qp4pckv",
                    "shift_name": "Shift #2",
                    "start_time": "2025-05-26T15:00:00.000000Z",
                    "end_time": "2025-05-26T20:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhdzp12t0918y8390ecsn1",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhdzpaqn88w82accyk4be7",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhdzpv7fq1m63h72xf23kh",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhdzq4y3vnnt62kxrd30d1",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhdzqepzr4h7wty94dt5vp",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhdznrh1sbkh3p22s42dxf",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhdzpjfrdwad18kswj47tg",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jvzhdzh68x5msv2rztb6we76",
                    "shift_name": "Shift #1",
                    "start_time": "2025-05-26T16:00:00.000000Z",
                    "end_time": "2025-05-26T21:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhdzj2qz0qnv7jx6vtqj4h",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhdzjbm2q5tdbpsbyj8g0d",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhdzh8bbhhys04afkfknc4",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhdzk7n7x3vp02hgmjeckb",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhdzhhf167q006rfnx69de",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhdzhsj61mk0xx2mw3apkd",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhdzjqzgj4gewb80bx0yse",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jvzhdztekkkrjns41eg5j2d1",
                    "shift_name": "Shift #3",
                    "start_time": "2025-05-26T11:00:00.000000Z",
                    "end_time": "2025-05-26T20:00:00.000000Z",
                    "worker_count": 8,
                    "workers": [
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhdztt8sb5mg7tm3bx2hb9",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhdzw3pfje4atqntneryns",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhdzv7anpkwvga8grntfyg",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhdztgk1vjegedw51dvt71",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhdzwba48dgwnm2x2dtmdw",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhdzvgvj38bqyy5cyt3rxm",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhdzwqdcn0t8szacgeak80",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdnez7db90xhd8h2b62sg",
                            "user_shift_id": "01jvzjvvsfres2k462rj9zhcje",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        }
                    ]
                },
                {
                    "shift_id": "01jvzhe0033pnhradj1s98mxbn",
                    "shift_name": "Shift #4",
                    "start_time": "2025-05-26T12:00:00.000000Z",
                    "end_time": "2025-05-26T17:00:00.000000Z",
                    "worker_count": 8,
                    "workers": [
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhe00wsbzf16gw1tzjgffw",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhe016q6kg9qwz9jwxeh2c",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhe01gep5mezq6a8q4vrg6",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhe02d4r2ps6n42bfcw796",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhe00gppez4c1vm74pyc6b",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhe01sk22qab6vw3eb6ea6",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhe026brg717yqj1aan6b0",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdnez7db90xhd8h2b62sg",
                            "user_shift_id": "01jvzjvyd7bqhhhe614jqy9e47",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jvzhdvm62ksknd5j3fsk4396",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "teal",
                "venue_comment": "",
                "address": "69149 Kamron Mountains Apt. 217\nNikolausbury, NC 98987-1181",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jvzjvs3jc82txenv296tpyvd",
            "shiftRequest_id": null,
            "shift_id": "01jvzhdznph16sc3c24qp4pckv",
            "schedule_id": "01jvzhdzghe16c6p2sajp18c2n",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jvzhdvm62ksknd5j3fsk4396",
            "venue_name": "Venue #1",
            "title": "Shift #2",
            "schedule_title": "Schedule #7",
            "call_time": 30,
            "start_time": "2025-05-26T15:00:00.000000Z",
            "end_time": "2025-05-26T20:00:00.000000Z",
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jvzhdznph16sc3c24qp4pckv",
                    "shift_name": "Shift #2",
                    "start_time": "2025-05-26T15:00:00.000000Z",
                    "end_time": "2025-05-26T20:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhdzp12t0918y8390ecsn1",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhdzpaqn88w82accyk4be7",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhdzpv7fq1m63h72xf23kh",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhdzq4y3vnnt62kxrd30d1",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhdzqepzr4h7wty94dt5vp",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhdznrh1sbkh3p22s42dxf",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhdzpjfrdwad18kswj47tg",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jvzhdzh68x5msv2rztb6we76",
                    "shift_name": "Shift #1",
                    "start_time": "2025-05-26T16:00:00.000000Z",
                    "end_time": "2025-05-26T21:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhdzj2qz0qnv7jx6vtqj4h",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhdzjbm2q5tdbpsbyj8g0d",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhdzh8bbhhys04afkfknc4",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhdzk7n7x3vp02hgmjeckb",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhdzhhf167q006rfnx69de",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhdzhsj61mk0xx2mw3apkd",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhdzjqzgj4gewb80bx0yse",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jvzhdztekkkrjns41eg5j2d1",
                    "shift_name": "Shift #3",
                    "start_time": "2025-05-26T11:00:00.000000Z",
                    "end_time": "2025-05-26T20:00:00.000000Z",
                    "worker_count": 8,
                    "workers": [
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhdztt8sb5mg7tm3bx2hb9",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhdzw3pfje4atqntneryns",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhdzv7anpkwvga8grntfyg",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhdztgk1vjegedw51dvt71",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhdzwba48dgwnm2x2dtmdw",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhdzvgvj38bqyy5cyt3rxm",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhdzwqdcn0t8szacgeak80",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdnez7db90xhd8h2b62sg",
                            "user_shift_id": "01jvzjvvsfres2k462rj9zhcje",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        }
                    ]
                },
                {
                    "shift_id": "01jvzhe0033pnhradj1s98mxbn",
                    "shift_name": "Shift #4",
                    "start_time": "2025-05-26T12:00:00.000000Z",
                    "end_time": "2025-05-26T17:00:00.000000Z",
                    "worker_count": 8,
                    "workers": [
                        {
                            "user_id": "01jvzhdrmx3rgcsgks6w5m2wez",
                            "user_shift_id": "01jvzhe00wsbzf16gw1tzjgffw",
                            "name": "Daphnee Wiza",
                            "avatar_url": "https://ui-avatars.com/api/?name=Daphnee+Wiza&color=000&background=EBF4FF",
                            "phone_number": "+1.720.888.9731",
                            "email": "freddie.murazik@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq1x74fc01c2v9n1tmdz",
                            "user_shift_id": "01jvzhe016q6kg9qwz9jwxeh2c",
                            "name": "Velda Monahan Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Velda+Monahan+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-469-753-4782",
                            "email": "sarai.ruecker@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdq88vex7vq9z8597gs37",
                            "user_shift_id": "01jvzhe01gep5mezq6a8q4vrg6",
                            "name": "Ike Conroy",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ike+Conroy&color=000&background=EBF4FF",
                            "phone_number": "(361) 452-4832",
                            "email": "kwilderman@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrrwemepfn3zbtkxe0r5",
                            "user_shift_id": "01jvzhe02d4r2ps6n42bfcw796",
                            "name": "Alicia Morar",
                            "avatar_url": "https://ui-avatars.com/api/?name=Alicia+Morar&color=000&background=EBF4FF",
                            "phone_number": "(629) 728-2472",
                            "email": "joanne.murphy@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jvzhdrv7h7amp2gx1crdy4rf",
                            "user_shift_id": "01jvzhe00gppez4c1vm74pyc6b",
                            "name": "Prof. Vella Volkman",
                            "avatar_url": "https://ui-avatars.com/api/?name=Prof.+Vella+Volkman&color=000&background=EBF4FF",
                            "phone_number": "641.725.8372",
                            "email": "lhoppe@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdrpd11dmgekphz4jgnss",
                            "user_shift_id": "01jvzhe01sk22qab6vw3eb6ea6",
                            "name": "Odie Balistreri",
                            "avatar_url": "https://ui-avatars.com/api/?name=Odie+Balistreri&color=000&background=EBF4FF",
                            "phone_number": "+1-351-607-2601",
                            "email": "toy.elliott@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdr19pxcm6bxmwfvt8e3m",
                            "user_shift_id": "01jvzhe026brg717yqj1aan6b0",
                            "name": "Dante Schoen",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dante+Schoen&color=000&background=EBF4FF",
                            "phone_number": "(302) 822-2848",
                            "email": "runolfsdottir.raquel@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jvzhdnez7db90xhd8h2b62sg",
                            "user_shift_id": "01jvzjvyd7bqhhhe614jqy9e47",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jvzhdvm62ksknd5j3fsk4396",
                "venue_name": "Venue #1",
                "venue_type": [
                    "bar"
                ],
                "venue_color": "teal",
                "venue_comment": "",
                "address": "69149 Kamron Mountains Apt. 217\nNikolausbury, NC 98987-1181",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/available-shifts?page=1",
        "last": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/available-shifts?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/available-shifts?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/worker/01JSJ7Q1Y5EEJPR9G40SZRMFB5/schedule/available-shifts",
        "per_page": 15,
        "to": 2,
        "total": 2
    }
}
```

### AvailableShifts Count

**Endpoint:** `GET api/v1/worker/available-shifts/available-count`

**Response:**
```json
{
    "count": int|null
}
```

### Shift Request Count

**Endpoint:** `GET api/v1/worker/shift-requests/pending-count`

**Response:**
```json
{
    "count": int|null
}
```

### Shift Requests

**Endpoint:** `GET api/worker/{team}/schedule/shift-requests`

**Response:**
```json
{
{
    "data": [
        {
            "id": "01jw2w53xx6p4kymef1jjgr87p",
            "shift_id": "01jw2w4hz4jr7wnj85b74fs4rz",
            "schedule_id": "01jw2vnnshxrczdh3rdd8akz75",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jw1jw4s5egwga1j18dydvmzc",
            "venue_name": "Venue #1",
            "title": "Event Logistics Coordinator",
            "schedule_title": "test fg",
            "call_time": 30,
            "start_time": "2025-05-26T05:00:00.000000Z",
            "end_time": "2025-05-26T09:00:00.000000Z",
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jw2vnnvh89pjhvd15ptm7h8s",
                    "shift_name": "Backline Technician",
                    "start_time": "2025-05-26T15:00:00.000000Z",
                    "end_time": "2025-05-27T03:00:00.000000Z",
                    "worker_count": 1,
                    "workers": [
                        {
                            "user_id": "01jw1jvz444y1c1c52x6xmtw8y",
                            "user_shift_id": "01jw2vnnwgc41rhrg7bk4dab7p",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jw2w4hz4jr7wnj85b74fs4rz",
                    "shift_name": "Event Logistics Coordinator",
                    "start_time": "2025-05-26T05:00:00.000000Z",
                    "end_time": null,
                    "worker_count": 1,
                    "workers": [
                        {
                            "user_id": "01jw1jvz444y1c1c52x6xmtw8y",
                            "user_shift_id": "01jw2w4hzbhtsdf00cdvy0rjzt",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jw1jw4s5egwga1j18dydvmzc",
                "venue_name": "Venue #1",
                "venue_type": [
                    "hotel"
                ],
                "venue_color": "purple",
                "venue_comment": "Impedit voluptas necessitatibus maxime qui vitae rerum necessitatibus.",
                "address": "463 Micheal Lock Suite 767\nGreenville, TN 38499",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        },
        {
            "id": "01jw2tw5cd9h2ythkgeq7hbza2",
            "shift_id": "01jw1jwe67cdy2yphznf0ekn19",
            "schedule_id": "01jw1jwdxsk231pdfzf5y16c25",
            "schedule_worker_notes": null,
            "schedule_admin_notes": null,
            "venue_id": "01jw1jw4s5egwga1j18dydvmzc",
            "venue_name": "Venue #1",
            "title": "Shift #2",
            "schedule_title": "Schedule #15",
            "call_time": 30,
            "start_time": "2025-06-21T20:00:00.000000Z",
            "end_time": "2025-06-22T05:00:00.000000Z",
            "worker_notes": null,
            "admin_notes": null,
            "workers": [
                {
                    "shift_id": "01jw1jwdya3gm5qqspgrzthh1w",
                    "shift_name": "Shift #1",
                    "start_time": "2025-06-21T18:00:00.000000Z",
                    "end_time": "2025-06-21T22:00:00.000000Z",
                    "worker_count": 7,
                    "workers": [
                        {
                            "user_id": "01jw1jw0ypw7965rfnj5xq6rg9",
                            "user_shift_id": "01jw1jwdzkds49p5hgvqajkfzk",
                            "name": "Mariana Larson",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mariana+Larson&color=000&background=EBF4FF",
                            "phone_number": "(470) 308-5140",
                            "email": "sziemann@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw25906tm20apgctezw5t",
                            "user_shift_id": "01jw1jwdzzz19s5sgh73k6g1dz",
                            "name": "Catharine Grimes",
                            "avatar_url": "https://ui-avatars.com/api/?name=Catharine+Grimes&color=000&background=EBF4FF",
                            "phone_number": "+1 (804) 951-6682",
                            "email": "mosciski.lesly@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0wmxkap5q4n00qg0ymm",
                            "user_shift_id": "01jw1jwdycjc703ym4yw1sr0zx",
                            "name": "Ms. Stephany McClure",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ms.+Stephany+McClure&color=000&background=EBF4FF",
                            "phone_number": "+1 (816) 387-4250",
                            "email": "connelly.hortense@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0fgxst8na0t7nc62t4p",
                            "user_shift_id": "01jw1jwe09zakngetr8ttne1jt",
                            "name": "Dr. Madisen Stokes Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dr.+Madisen+Stokes+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-863-721-7210",
                            "email": "santa57@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0xjk5cyw6cy6ceyefqr",
                            "user_shift_id": "01jw1jwe0k25927czx6kbx2yjc",
                            "name": "Annamarie Powlowski",
                            "avatar_url": "https://ui-avatars.com/api/?name=Annamarie+Powlowski&color=000&background=EBF4FF",
                            "phone_number": "(463) 318-3457",
                            "email": "abraham21@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0w14v81ej18wcqzefeq",
                            "user_shift_id": "01jw1jwe11vrbebpwhpg0sgx1x",
                            "name": "Rhianna King",
                            "avatar_url": "https://ui-avatars.com/api/?name=Rhianna+King&color=000&background=EBF4FF",
                            "phone_number": "1-208-553-9491",
                            "email": "jquitzon@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0nan0ensaynzcc0fc6r",
                            "user_shift_id": "01jw1jwdykfet8dg8768fzevs8",
                            "name": "Kenny Goodwin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Kenny+Goodwin&color=000&background=EBF4FF",
                            "phone_number": "+13166244156",
                            "email": "stanley.miller@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        }
                    ]
                },
                {
                    "shift_id": "01jw1jwe67cdy2yphznf0ekn19",
                    "shift_name": "Shift #2",
                    "start_time": "2025-06-21T20:00:00.000000Z",
                    "end_time": "2025-06-22T05:00:00.000000Z",
                    "worker_count": 8,
                    "workers": [
                        {
                            "user_id": "01jw1jw0nan0ensaynzcc0fc6r",
                            "user_shift_id": "01jw1jwe6pxf936dg981xraj2e",
                            "name": "Kenny Goodwin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Kenny+Goodwin&color=000&background=EBF4FF",
                            "phone_number": "+13166244156",
                            "email": "stanley.miller@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw25906tm20apgctezw5t",
                            "user_shift_id": "01jw1jwe7c9nfthx195kp56qph",
                            "name": "Catharine Grimes",
                            "avatar_url": "https://ui-avatars.com/api/?name=Catharine+Grimes&color=000&background=EBF4FF",
                            "phone_number": "+1 (804) 951-6682",
                            "email": "mosciski.lesly@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jw1jw0fgxst8na0t7nc62t4p",
                            "user_shift_id": "01jw1jwe7pnb76dcnp2ea67ye8",
                            "name": "Dr. Madisen Stokes Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dr.+Madisen+Stokes+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-863-721-7210",
                            "email": "santa57@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0ypw7965rfnj5xq6rg9",
                            "user_shift_id": "01jw1jwe74apvsdvw0vyhgwefh",
                            "name": "Mariana Larson",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mariana+Larson&color=000&background=EBF4FF",
                            "phone_number": "(470) 308-5140",
                            "email": "sziemann@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jw1jw0w14v81ej18wcqzefeq",
                            "user_shift_id": "01jw1jwe89f18ge6sgnv66hb9a",
                            "name": "Rhianna King",
                            "avatar_url": "https://ui-avatars.com/api/?name=Rhianna+King&color=000&background=EBF4FF",
                            "phone_number": "1-208-553-9491",
                            "email": "jquitzon@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0xjk5cyw6cy6ceyefqr",
                            "user_shift_id": "01jw1jwe80k52mca91s2p3bgvj",
                            "name": "Annamarie Powlowski",
                            "avatar_url": "https://ui-avatars.com/api/?name=Annamarie+Powlowski&color=000&background=EBF4FF",
                            "phone_number": "(463) 318-3457",
                            "email": "abraham21@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jw1jw0wmxkap5q4n00qg0ymm",
                            "user_shift_id": "01jw1jwe6a5jx8rqmjyd035s04",
                            "name": "Ms. Stephany McClure",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ms.+Stephany+McClure&color=000&background=EBF4FF",
                            "phone_number": "+1 (816) 387-4250",
                            "email": "connelly.hortense@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jvz444y1c1c52x6xmtw8y",
                            "user_shift_id": "01jw2ttb324r54saxkr56n70xp",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        }
                    ]
                },
                {
                    "shift_id": "01jw1jwebhr3wykjh2vbch36cc",
                    "shift_name": "Shift #3",
                    "start_time": "2025-06-21T11:00:00.000000Z",
                    "end_time": "2025-06-22T00:00:00.000000Z",
                    "worker_count": 8,
                    "workers": [
                        {
                            "user_id": "01jw1jw0ypw7965rfnj5xq6rg9",
                            "user_shift_id": "01jw1jwec78sthxywp98dc7j45",
                            "name": "Mariana Larson",
                            "avatar_url": "https://ui-avatars.com/api/?name=Mariana+Larson&color=000&background=EBF4FF",
                            "phone_number": "(470) 308-5140",
                            "email": "sziemann@example.com",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0nan0ensaynzcc0fc6r",
                            "user_shift_id": "01jw1jwebxwnqd5apg2nyk8037",
                            "name": "Kenny Goodwin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Kenny+Goodwin&color=000&background=EBF4FF",
                            "phone_number": "+13166244156",
                            "email": "stanley.miller@example.net",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jw1jw0xjk5cyw6cy6ceyefqr",
                            "user_shift_id": "01jw1jwed6x9gt3cap9a49eykp",
                            "name": "Annamarie Powlowski",
                            "avatar_url": "https://ui-avatars.com/api/?name=Annamarie+Powlowski&color=000&background=EBF4FF",
                            "phone_number": "(463) 318-3457",
                            "email": "abraham21@example.org",
                            "user_shift_status": null,
                            "shift_request_status": "pending"
                        },
                        {
                            "user_id": "01jw1jw0wmxkap5q4n00qg0ymm",
                            "user_shift_id": "01jw1jwebk9mrab43a5nm6xyrf",
                            "name": "Ms. Stephany McClure",
                            "avatar_url": "https://ui-avatars.com/api/?name=Ms.+Stephany+McClure&color=000&background=EBF4FF",
                            "phone_number": "+1 (816) 387-4250",
                            "email": "connelly.hortense@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw25906tm20apgctezw5t",
                            "user_shift_id": "01jw1jweckvpd0zdb0zbg23qc4",
                            "name": "Catharine Grimes",
                            "avatar_url": "https://ui-avatars.com/api/?name=Catharine+Grimes&color=000&background=EBF4FF",
                            "phone_number": "+1 (804) 951-6682",
                            "email": "mosciski.lesly@example.net",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0fgxst8na0t7nc62t4p",
                            "user_shift_id": "01jw1jwecx381gmcj80rffm2mc",
                            "name": "Dr. Madisen Stokes Sr.",
                            "avatar_url": "https://ui-avatars.com/api/?name=Dr.+Madisen+Stokes+Sr.&color=000&background=EBF4FF",
                            "phone_number": "+1-863-721-7210",
                            "email": "santa57@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jw0w14v81ej18wcqzefeq",
                            "user_shift_id": "01jw1jwedged69pv375vbbpz3m",
                            "name": "Rhianna King",
                            "avatar_url": "https://ui-avatars.com/api/?name=Rhianna+King&color=000&background=EBF4FF",
                            "phone_number": "1-208-553-9491",
                            "email": "jquitzon@example.org",
                            "user_shift_status": "arrived",
                            "shift_request_status": "confirmed"
                        },
                        {
                            "user_id": "01jw1jvz444y1c1c52x6xmtw8y",
                            "user_shift_id": "01jw2ttear2m39fae0r2043myr",
                            "name": "Company Admin",
                            "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                            "phone_number": "1234567892",
                            "email": "companyadmin@example.com",
                            "user_shift_status": null,
                            "shift_request_status": "confirmed"
                        }
                    ]
                }
            ],
            "venue": {
                "id": "01jw1jw4s5egwga1j18dydvmzc",
                "venue_name": "Venue #1",
                "venue_type": [
                    "hotel"
                ],
                "venue_color": "purple",
                "venue_comment": "Impedit voluptas necessitatibus maxime qui vitae rerum necessitatibus.",
                "address": "463 Micheal Lock Suite 767\nGreenville, TN 38499",
                "latitude": "29.767544",
                "longitude": "-95.362125"
            }
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/worker/houston/schedule/shift-requests?page=1",
        "last": "http://127.0.0.1:8000/api/worker/houston/schedule/shift-requests?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/worker/houston/schedule/shift-requests?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/worker/houston/schedule/shift-requests",
        "per_page": 15,
        "to": 2,
        "total": 2
    }
}
}
```

### Handle Shift Request

**Endpoint:** `PATCH api/v1/shift-requests/status`

**Request:**
```json
{
  "status": "enum,string enum UserShiftStatus: string
{
    case CONFIRMED = 'confirmed';
    case REQUESTED = 'requested';
    case DECLINED = 'declined';
    case BAILOUT = 'bailout';
    case BAILOUTCONFIRMED = 'bailoutconfirmed';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';
    case CONTACTED = 'contacted';",
  "shift_request_id": "null | shiftRequest.id Model",
  "user_shift_id": "null | userShift.id Model"
}
```



#### MyTimeOff

**Endpoint:** `GET api/worker/{team}/schedule/time-off-requests`

**Response:**
```json
{
    "data": [
        {
            "id": "01jw27v7vnt6m6zf03krp2z9xk",
            "user_id": "01jw1jvz444y1c1c52x6xmtw8y",
            "start_date": "2025-05-25T05:00:00.000000Z",
            "end_date": "2025-05-31T05:00:00.000000Z",
            "reason": "sick",
            "status": "approved",
            "deleted_at": null,
            "created_at": "2025-05-24T22:50:31.000000Z",
            "updated_at": "2025-05-24T22:50:31.000000Z",
            "date_range": "2025-05-25 to 2025-05-31"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/worker/hourston/schedule/time-off-requests?page=1",
        "last": "http://127.0.0.1:8000/api/worker/hourston/schedule/time-off-requests?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/worker/hourston/schedule/time-off-requests?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/worker/hourston/schedule/time-off-requests",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

```typescript
//need to be redone with current api response
```

#### MyTimeOff -Create

**Endpoint:** `POST api/worker/{team}/schedule/time-off-requests`

**Request:**
```json
{
    "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
    "start_date": "2025-08-15T05:00:00.000000Z",
    "end_date": "2025-08-22T05:00:00.000000Z",
    "reason": "sick",
}
```

**Response:**
```json
{
    "message": "Successfully Create Resource",
    "data": {
        "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
        "start_date": "2025-08-15T05:00:00.000000Z",
        "end_date": "2025-08-22T05:00:00.000000Z",
        "reason": "sick",
        "id": "01jvmx4qw3jswy68d1ynn85thx",
        "status": "approved",
        "updated_at": "2025-05-19T18:33:20.000000Z",
        "created_at": "2025-05-19T18:33:20.000000Z",
        "date_range": "2025-08-15 to 2025-08-22"
    }
}
```


#### MyAvailability

**Endpoint:** `GET api/worker/hourston/schedule/availability`

**Response:**
```json
{
    "data": [
        {
            "id": "01jvr3s54t7mmybmej0ybg6p58",
            "team_id": "01JVDVD8RPWE3DW4QEN781CKXX",
            "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
            "start_date": "2025-05-26T05:00:00.000000Z",
            "end_date": "2025-05-26T05:00:00.000000Z",
            "recurrence": false,
            "recurrence_limit": null,
            "deleted_at": null,
            "created_at": "2025-05-21T00:27:04.000000Z",
            "updated_at": "2025-05-21T00:27:04.000000Z",
            "date_range": "2025-05-26 to 2025-05-26"
        },
        {
            "id": "01jvr81c8127qvzfqv0295bvfc",
            "team_id": "01JVDVD8RPWE3DW4QEN781CKXX",
            "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
            "start_date": "2025-05-27T05:00:00.000000Z",
            "end_date": "2025-05-28T05:00:00.000000Z",
            "metadata": [
                {
                    "notes": null
                }
            ],
            "recurrence": false,
            "recurrence_limit": null,
            "deleted_at": null,
            "created_at": "2025-05-21T01:41:27.000000Z",
            "updated_at": "2025-05-21T01:41:27.000000Z",
            "date_range": "2025-05-27 to 2025-05-28"
        },
        {
            "id": "01jvr90qtyjt02xsqnwvnp40j5",
            "team_id": "01JVDVD8RPWE3DW4QEN781CKXX",
            "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
            "start_date": "2025-05-31T10:00:00.000000Z",
            "end_date": "2025-05-31T10:00:00.000000Z",
            "metadata": [
                {
                    "notes": "Wow"
                }
            ],
            "recurrence": false,
            "recurrence_limit": null,
            "deleted_at": null,
            "created_at": "2025-05-21T01:58:35.000000Z",
            "updated_at": "2025-05-21T02:07:17.000000Z",
            "date_range": "2025-05-31 to 2025-05-31"
        },
        {
            "id": "01jvjm3jynckfkcb6e1ep6zam1",
            "team_id": "01JVDVD8RPWE3DW4QEN781CKXX",
            "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
            "start_date": "2025-05-19T22:00:00.000000Z",
            "end_date": "2025-05-25T11:17:00.000000Z",
            "metadata": [
                {
                    "notes": "Wow!"
                }
            ],
            "recurrence": false,
            "recurrence_limit": null,
            "deleted_at": null,
            "created_at": "2025-05-18T21:16:56.000000Z",
            "updated_at": "2025-05-21T02:27:26.000000Z",
            "date_range": "2025-05-19 to 2025-05-25"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/worker/hourston/schedule/availability?page=1",
        "last": "http://127.0.0.1:8000/api/worker/hourston/schedule/availability?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/worker/hourston/schedule/availability?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/worker/hourston/schedule/availability",
        "per_page": 15,
        "to": 4,
        "total": 4
    }
}
```

```typescript
//need to be redone with current api response
```

#### MyAvailability -Create

**Endpoint:** `POST api/worker/{team}/schedule/availability`

**Request:**
```json
{
    'user_id': 'required',
    'team_id': 'required',
	'start_date': 'required',
    'end_date': 'required',
	'metadata': 'required', //reason (string|null)
	'recurrence': 'boolean',
    'recurrence_limit': 'required_if:recurrence,true',
}
```

**Response:**
```json
{
    "message": "Successfully Create Resource",
    "data": {
       ...
    }
}
```

#### MyHours

**Endpoint:** `GET api/v1/worker/MyHours`

**Request:**
```json
{
    "to": "beginning of month using datetime",
    "from": "end of month using datetime"
}
```
```typescript
//need to be redone with current api response
```

**Response:**
```json
[
    {
        "id": "01jvdve7eaqq7ebtatzppjnx0q",
        "shift-request-id": "01jvdve7esd24p2masrh3q3fnz",
        "shift_id": "01jvdve7a66c8snkry25njvv0f",
        "schedule_id": "01jvdve71w9nscam68cqjfqwhx",
        "schedule_worker_notes": null,
        "schedule_admin_notes": null,
        "venue_id": "01jvdve26hj45wdj0gbaxc6vdm",
        "venue_name": "Venue #1",
        "title": "Shift #2",
        "schedule_title": "Schedule #3",
        "can_punch": false,
        "can_bailout": true,
        "call_time": 30,
        "start_time": "2025-07-03T11:00:00.000000Z",
        "end_time": "2025-07-03T15:00:00.000000Z",
        "timePunches": [],
        "worker_notes": null,
        "admin_notes": null,
        "workers": [
            {
                "shift_id": "01jvdve72gx06f2n2rk9g8mkpg",
                "shift_name": "Shift #1",
                "start_time": "2025-07-03T17:00:00.000000Z",
                "end_time": "2025-07-04T06:00:00.000000Z",
                "worker_count": 6,
                "workers": [
                    {
                        "user_id": "01jvdvdv6fkaessbxwt43srh8x",
                        "user_shift_id": "01jvdve72mjfqnyd6r8gfdjhe5",
                        "name": "Lauretta Roberts",
                        "avatar_url": "https://ui-avatars.com/api/?name=Lauretta+Roberts&color=000&background=EBF4FF",
                        "phone_number": "(361) 969-5430",
                        "email": "joaquin68@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdezss51vbs2fkg46q85a",
                        "user_shift_id": "01jvdve737sqwr4twdezhd8wrr",
                        "name": "Roberta Batz V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Roberta+Batz+V&color=000&background=EBF4FF",
                        "phone_number": "(714) 827-1484",
                        "email": "gutmann.nora@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdj7y4z79wtnzw4e34hq2",
                        "user_shift_id": "01jvdve74hnjnf7ascwrdpepjg",
                        "name": "Melyssa Schumm IV",
                        "avatar_url": "https://ui-avatars.com/api/?name=Melyssa+Schumm+IV&color=000&background=EBF4FF",
                        "phone_number": "+1 (276) 420-0264",
                        "email": "jalyn18@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvde4y0b2srtk80pys3bcp",
                        "user_shift_id": "01jvdve74x9td0v23p6qtbzec1",
                        "name": "Reta Kuphal",
                        "avatar_url": "https://ui-avatars.com/api/?name=Reta+Kuphal&color=000&background=EBF4FF",
                        "phone_number": "312-408-0710",
                        "email": "marlee23@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdfyeg4za8k5c23w36j9z",
                        "user_shift_id": "01jvdve75ra44qwcjhj6aysx83",
                        "name": "Ludie Keebler",
                        "avatar_url": "https://ui-avatars.com/api/?name=Ludie+Keebler&color=000&background=EBF4FF",
                        "phone_number": "1-762-433-6789",
                        "email": "ariane44@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdsa5smpd1fby74gcnwbs",
                        "user_shift_id": "01jvdve76zw7e4w5yaqjzz8sz6",
                        "name": "Creola Williamson",
                        "avatar_url": "https://ui-avatars.com/api/?name=Creola+Williamson&color=000&background=EBF4FF",
                        "phone_number": "(989) 687-3976",
                        "email": "vmorar@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    }
                ]
            },
            {
                "shift_id": "01jvdve7a66c8snkry25njvv0f",
                "shift_name": "Shift #2",
                "start_time": "2025-07-03T11:00:00.000000Z",
                "end_time": null,
                "worker_count": 7,
                "workers": [
                    {
                        "user_id": "01jvdvdv6fkaessbxwt43srh8x",
                        "user_shift_id": "01jvdve7a9yvjx1rec7ddp3xm4",
                        "name": "Lauretta Roberts",
                        "avatar_url": "https://ui-avatars.com/api/?name=Lauretta+Roberts&color=000&background=EBF4FF",
                        "phone_number": "(361) 969-5430",
                        "email": "joaquin68@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdezss51vbs2fkg46q85a",
                        "user_shift_id": "01jvdve7b8jd7e14che97pbvh7",
                        "name": "Roberta Batz V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Roberta+Batz+V&color=000&background=EBF4FF",
                        "phone_number": "(714) 827-1484",
                        "email": "gutmann.nora@example.com",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdj7y4z79wtnzw4e34hq2",
                        "user_shift_id": "01jvdve7bjeh32xqgwksk4vhv6",
                        "name": "Melyssa Schumm IV",
                        "avatar_url": "https://ui-avatars.com/api/?name=Melyssa+Schumm+IV&color=000&background=EBF4FF",
                        "phone_number": "+1 (276) 420-0264",
                        "email": "jalyn18@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvde4y0b2srtk80pys3bcp",
                        "user_shift_id": "01jvdve7by1ephng7yw2rdb890",
                        "name": "Reta Kuphal",
                        "avatar_url": "https://ui-avatars.com/api/?name=Reta+Kuphal&color=000&background=EBF4FF",
                        "phone_number": "312-408-0710",
                        "email": "marlee23@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdfyeg4za8k5c23w36j9z",
                        "user_shift_id": "01jvdve7f5cway0vmjpr3ywv5y",
                        "name": "Ludie Keebler",
                        "avatar_url": "https://ui-avatars.com/api/?name=Ludie+Keebler&color=000&background=EBF4FF",
                        "phone_number": "1-762-433-6789",
                        "email": "ariane44@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdsa5smpd1fby74gcnwbs",
                        "user_shift_id": "01jvdve7fgnv3w98gbqyvns822",
                        "name": "Creola Williamson",
                        "avatar_url": "https://ui-avatars.com/api/?name=Creola+Williamson&color=000&background=EBF4FF",
                        "phone_number": "(989) 687-3976",
                        "email": "vmorar@example.net",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
                        "user_shift_id": "01jvdve7eaqq7ebtatzppjnx0q",
                        "name": "Company Admin",
                        "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                        "phone_number": "1234567892",
                        "email": "companyadmin@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "confirmed"
                    }
                ]
            }
        ],
        "venue": {
            "id": "01jvdve26hj45wdj0gbaxc6vdm",
            "venue_name": "Venue #1",
            "venue_type": [
                "venue"
            ],
            "venue_color": "gray",
            "venue_comment": "",
            "address": "89941 Cassin Mission\nPort Shanonhaven, NY 01401-0070",
            "latitude": "29.767544",
            "longitude": "-95.362125"
        }
    },
    {
        "id": "01jvdveg9xqkg2tzxkk5nsq3da",
        "shift-request-id": "01jvdvega1mxqkvts3mmxjare8",
        "shift_id": "01jvdveg8s4bazyd8c8z4bfada",
        "schedule_id": "01jvdveg8cb63wx9ee0y8z5ebf",
        "schedule_worker_notes": null,
        "schedule_admin_notes": null,
        "venue_id": "01jvdve26hj45wdj0gbaxc6vdm",
        "venue_name": "Venue #1",
        "title": "Shift #1",
        "schedule_title": "Schedule #12",
        "can_punch": false,
        "can_bailout": true,
        "call_time": 30,
        "start_time": "2025-06-18T14:00:00.000000Z",
        "end_time": "2025-06-19T02:00:00.000000Z",
        "timePunches": [],
        "worker_notes": null,
        "admin_notes": null,
        "workers": [
            {
                "shift_id": "01jvdveg8s4bazyd8c8z4bfada",
                "shift_name": "Shift #1",
                "start_time": "2025-06-18T14:00:00.000000Z",
                "end_time": "2025-06-19T02:00:00.000000Z",
                "worker_count": 7,
                "workers": [
                    {
                        "user_id": "01jvdvdg7a2mbp3nmbdw1k5mv4",
                        "user_shift_id": "01jvdveg8y81zt35d5vcadrkdq",
                        "name": "Norberto Rempel",
                        "avatar_url": "https://ui-avatars.com/api/?name=Norberto+Rempel&color=000&background=EBF4FF",
                        "phone_number": "1-409-516-9314",
                        "email": "jbernier@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdj7y4z79wtnzw4e34hq2",
                        "user_shift_id": "01jvdveg9jsjr1atzf43mebyk0",
                        "name": "Melyssa Schumm IV",
                        "avatar_url": "https://ui-avatars.com/api/?name=Melyssa+Schumm+IV&color=000&background=EBF4FF",
                        "phone_number": "+1 (276) 420-0264",
                        "email": "jalyn18@example.net",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdsa5smpd1fby74gcnwbs",
                        "user_shift_id": "01jvdvega81zp1zn8dwnn4ad8z",
                        "name": "Creola Williamson",
                        "avatar_url": "https://ui-avatars.com/api/?name=Creola+Williamson&color=000&background=EBF4FF",
                        "phone_number": "(989) 687-3976",
                        "email": "vmorar@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdk84xy0cvp59eads2e03",
                        "user_shift_id": "01jvdvegapeet2ga0rcx4mmsmq",
                        "name": "Cristal Boyle V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Cristal+Boyle+V&color=000&background=EBF4FF",
                        "phone_number": "203-368-8377",
                        "email": "hahn.esther@example.org",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdvg5fh0fsb3rcmxsg26z",
                        "user_shift_id": "01jvdvegbc7g9ggp81gcp6t6e7",
                        "name": "Erling Upton",
                        "avatar_url": "https://ui-avatars.com/api/?name=Erling+Upton&color=000&background=EBF4FF",
                        "phone_number": "+1.908.948.2989",
                        "email": "tyrell02@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdwr36q5jh67pemd5j1dh",
                        "user_shift_id": "01jvdvegbq6nkhpptv345txntw",
                        "name": "Kylie Zemlak V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Kylie+Zemlak+V&color=000&background=EBF4FF",
                        "phone_number": "(469) 427-0170",
                        "email": "ryder19@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
                        "user_shift_id": "01jvdveg9xqkg2tzxkk5nsq3da",
                        "name": "Company Admin",
                        "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                        "phone_number": "1234567892",
                        "email": "companyadmin@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "confirmed"
                    }
                ]
            },
            {
                "shift_id": "01jvdveggkkhzk5fca7nj9yg36",
                "shift_name": "Shift #2",
                "start_time": "2025-06-18T12:00:00.000000Z",
                "end_time": "2025-06-18T20:00:00.000000Z",
                "worker_count": 6,
                "workers": [
                    {
                        "user_id": "01jvdvdg7a2mbp3nmbdw1k5mv4",
                        "user_shift_id": "01jvdveggqep66safqe6v7kf2b",
                        "name": "Norberto Rempel",
                        "avatar_url": "https://ui-avatars.com/api/?name=Norberto+Rempel&color=000&background=EBF4FF",
                        "phone_number": "1-409-516-9314",
                        "email": "jbernier@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdj7y4z79wtnzw4e34hq2",
                        "user_shift_id": "01jvdvegh7y71dkstmqt4ryeab",
                        "name": "Melyssa Schumm IV",
                        "avatar_url": "https://ui-avatars.com/api/?name=Melyssa+Schumm+IV&color=000&background=EBF4FF",
                        "phone_number": "+1 (276) 420-0264",
                        "email": "jalyn18@example.net",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdsa5smpd1fby74gcnwbs",
                        "user_shift_id": "01jvdvegk31s6wxjzdt9ptr50x",
                        "name": "Creola Williamson",
                        "avatar_url": "https://ui-avatars.com/api/?name=Creola+Williamson&color=000&background=EBF4FF",
                        "phone_number": "(989) 687-3976",
                        "email": "vmorar@example.net",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdk84xy0cvp59eads2e03",
                        "user_shift_id": "01jvdvegmhtzb9vwdzxebv39k3",
                        "name": "Cristal Boyle V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Cristal+Boyle+V&color=000&background=EBF4FF",
                        "phone_number": "203-368-8377",
                        "email": "hahn.esther@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdvg5fh0fsb3rcmxsg26z",
                        "user_shift_id": "01jvdvegmwmn11zv3s6vv1jnq6",
                        "name": "Erling Upton",
                        "avatar_url": "https://ui-avatars.com/api/?name=Erling+Upton&color=000&background=EBF4FF",
                        "phone_number": "+1.908.948.2989",
                        "email": "tyrell02@example.org",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdwr36q5jh67pemd5j1dh",
                        "user_shift_id": "01jvdvegncq9b8yxxjvd800xh6",
                        "name": "Kylie Zemlak V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Kylie+Zemlak+V&color=000&background=EBF4FF",
                        "phone_number": "(469) 427-0170",
                        "email": "ryder19@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    }
                ]
            }
        ],
        "venue": {
            "id": "01jvdve26hj45wdj0gbaxc6vdm",
            "venue_name": "Venue #1",
            "venue_type": [
                "venue"
            ],
            "venue_color": "gray",
            "venue_comment": "",
            "address": "89941 Cassin Mission\nPort Shanonhaven, NY 01401-0070",
            "latitude": "29.767544",
            "longitude": "-95.362125"
        }
    },
    {
        "id": "01jvjfnkftczzxrdzgxxyp8v0y",
        "shift-request-id": "01jvt2wbdr43f9nstcm8kbb9d9",
        "shift_id": "01jvdve9xy0adn5gsb7e45m45g",
        "schedule_id": "01jvdve9e281m4qtvz4et2wv7a",
        "schedule_worker_notes": null,
        "schedule_admin_notes": null,
        "venue_id": "01jvdve26hj45wdj0gbaxc6vdm",
        "venue_name": "Venue #1",
        "title": "Shift #3",
        "schedule_title": "Schedule #6",
        "can_punch": false,
        "can_bailout": true,
        "call_time": 30,
        "start_time": "2025-05-23T19:00:00.000000Z",
        "end_time": "2025-05-24T08:00:00.000000Z",
        "timePunches": [
            {
                "id": "01jvt2x87vt41h28yqjxk7m01m",
                "punch_time": "2025-05-23T19:00:00.000000Z",
                "type": "in",
                "reason": null,
                "latitude": null,
                "longitude": null,
                "approved": false,
                "order_column": 1
            },
            {
                "id": "01jvt2xt5p76t13j6tawq8k95s",
                "punch_time": "2025-05-23T22:00:00.000000Z",
                "type": "out",
                "reason": null,
                "latitude": null,
                "longitude": null,
                "approved": false,
                "order_column": 2
            }
        ],
        "worker_notes": null,
        "admin_notes": null,
        "workers": [
            {
                "shift_id": "01jvdve9f1qmfn2jz5gp33gkrg",
                "shift_name": "Shift #1",
                "start_time": "2025-05-23T11:00:00.000000Z",
                "end_time": "2025-05-24T00:00:00.000000Z",
                "worker_count": 7,
                "workers": [
                    {
                        "user_id": "01jvdvdgbhkkk2a78xpb6a2kz5",
                        "user_shift_id": "01jvdve9f7368k9edksb5bewqz",
                        "name": "Obie Brown",
                        "avatar_url": "https://ui-avatars.com/api/?name=Obie+Brown&color=000&background=EBF4FF",
                        "phone_number": "+1-424-427-7659",
                        "email": "legros.susana@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdg55cr40ww875z2mherw",
                        "user_shift_id": "01jvdve9fjeb9t36s87yey678p",
                        "name": "Raphaelle Stanton",
                        "avatar_url": "https://ui-avatars.com/api/?name=Raphaelle+Stanton&color=000&background=EBF4FF",
                        "phone_number": "+1.612.298.9540",
                        "email": "casimer60@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdtbcfc9fnkdhvw0n1b2b",
                        "user_shift_id": "01jvdve9fxwktepgga7n987yqh",
                        "name": "Orville Wiza",
                        "avatar_url": "https://ui-avatars.com/api/?name=Orville+Wiza&color=000&background=EBF4FF",
                        "phone_number": "409-900-3247",
                        "email": "hallie.doyle@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdreb9fh7mabk1jz4masa",
                        "user_shift_id": "01jvdve9gc5hhcp9f9n66a5jn1",
                        "name": "Zion Rowe",
                        "avatar_url": "https://ui-avatars.com/api/?name=Zion+Rowe&color=000&background=EBF4FF",
                        "phone_number": "1-463-316-8519",
                        "email": "lheaney@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdfcf87teprrxjn3y1w3v",
                        "user_shift_id": "01jvdve9gswk5amzb9r18zrs6t",
                        "name": "Dr. Reginald Hickle",
                        "avatar_url": "https://ui-avatars.com/api/?name=Dr.+Reginald+Hickle&color=000&background=EBF4FF",
                        "phone_number": "830.674.0491",
                        "email": "brook55@example.com",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdf4e3nbmqsp5pd5ztvxx",
                        "user_shift_id": "01jvdve9h4th3pqfshwfzxqcwf",
                        "name": "Kailey Rice",
                        "avatar_url": "https://ui-avatars.com/api/?name=Kailey+Rice&color=000&background=EBF4FF",
                        "phone_number": "+13076137080",
                        "email": "phermiston@example.org",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdezss51vbs2fkg46q85a",
                        "user_shift_id": "01jvdve9hqe3c81vzvmmv01b76",
                        "name": "Roberta Batz V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Roberta+Batz+V&color=000&background=EBF4FF",
                        "phone_number": "(714) 827-1484",
                        "email": "gutmann.nora@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    }
                ]
            },
            {
                "shift_id": "01jvdve9mdq749gn37mpnnq0kb",
                "shift_name": "Shift #2",
                "start_time": "2025-05-23T11:00:00.000000Z",
                "end_time": "2025-05-23T18:00:00.000000Z",
                "worker_count": 7,
                "workers": [
                    {
                        "user_id": "01jvdvdgbhkkk2a78xpb6a2kz5",
                        "user_shift_id": "01jvdve9mnkw1e0q1dbykbabba",
                        "name": "Obie Brown",
                        "avatar_url": "https://ui-avatars.com/api/?name=Obie+Brown&color=000&background=EBF4FF",
                        "phone_number": "+1-424-427-7659",
                        "email": "legros.susana@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdg55cr40ww875z2mherw",
                        "user_shift_id": "01jvdve9n03h25e4r35pwv706k",
                        "name": "Raphaelle Stanton",
                        "avatar_url": "https://ui-avatars.com/api/?name=Raphaelle+Stanton&color=000&background=EBF4FF",
                        "phone_number": "+1.612.298.9540",
                        "email": "casimer60@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdtbcfc9fnkdhvw0n1b2b",
                        "user_shift_id": "01jvdve9ns35m3rfkpy2kpc9vn",
                        "name": "Orville Wiza",
                        "avatar_url": "https://ui-avatars.com/api/?name=Orville+Wiza&color=000&background=EBF4FF",
                        "phone_number": "409-900-3247",
                        "email": "hallie.doyle@example.com",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdreb9fh7mabk1jz4masa",
                        "user_shift_id": "01jvdve9pbjx4f0ebaqbyw8wz1",
                        "name": "Zion Rowe",
                        "avatar_url": "https://ui-avatars.com/api/?name=Zion+Rowe&color=000&background=EBF4FF",
                        "phone_number": "1-463-316-8519",
                        "email": "lheaney@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdfcf87teprrxjn3y1w3v",
                        "user_shift_id": "01jvdve9pp3rmtt08r145179j9",
                        "name": "Dr. Reginald Hickle",
                        "avatar_url": "https://ui-avatars.com/api/?name=Dr.+Reginald+Hickle&color=000&background=EBF4FF",
                        "phone_number": "830.674.0491",
                        "email": "brook55@example.com",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdf4e3nbmqsp5pd5ztvxx",
                        "user_shift_id": "01jvdve9q1fbcqbftg4hfmxr98",
                        "name": "Kailey Rice",
                        "avatar_url": "https://ui-avatars.com/api/?name=Kailey+Rice&color=000&background=EBF4FF",
                        "phone_number": "+13076137080",
                        "email": "phermiston@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdezss51vbs2fkg46q85a",
                        "user_shift_id": "01jvdve9qdn4pte7ps25p51tfy",
                        "name": "Roberta Batz V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Roberta+Batz+V&color=000&background=EBF4FF",
                        "phone_number": "(714) 827-1484",
                        "email": "gutmann.nora@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    }
                ]
            },
            {
                "shift_id": "01jvdve9xy0adn5gsb7e45m45g",
                "shift_name": "Shift #3",
                "start_time": "2025-05-23T19:00:00.000000Z",
                "end_time": "2025-05-24T08:00:00.000000Z",
                "worker_count": 8,
                "workers": [
                    {
                        "user_id": "01jvdvdgbhkkk2a78xpb6a2kz5",
                        "user_shift_id": "01jvdve9y1rrgqxhtwgdxs628k",
                        "name": "Obie Brown",
                        "avatar_url": "https://ui-avatars.com/api/?name=Obie+Brown&color=000&background=EBF4FF",
                        "phone_number": "+1-424-427-7659",
                        "email": "legros.susana@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdg55cr40ww875z2mherw",
                        "user_shift_id": "01jvdve9ynst7db2tzsyzb31xr",
                        "name": "Raphaelle Stanton",
                        "avatar_url": "https://ui-avatars.com/api/?name=Raphaelle+Stanton&color=000&background=EBF4FF",
                        "phone_number": "+1.612.298.9540",
                        "email": "casimer60@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdtbcfc9fnkdhvw0n1b2b",
                        "user_shift_id": "01jvdve9z3dsarvgfrbwrc2ee9",
                        "name": "Orville Wiza",
                        "avatar_url": "https://ui-avatars.com/api/?name=Orville+Wiza&color=000&background=EBF4FF",
                        "phone_number": "409-900-3247",
                        "email": "hallie.doyle@example.com",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdreb9fh7mabk1jz4masa",
                        "user_shift_id": "01jvdve9zn6fnp0q2jz23vx1t7",
                        "name": "Zion Rowe",
                        "avatar_url": "https://ui-avatars.com/api/?name=Zion+Rowe&color=000&background=EBF4FF",
                        "phone_number": "1-463-316-8519",
                        "email": "lheaney@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdfcf87teprrxjn3y1w3v",
                        "user_shift_id": "01jvdvea02tr66s7zk3g1ek9ze",
                        "name": "Dr. Reginald Hickle",
                        "avatar_url": "https://ui-avatars.com/api/?name=Dr.+Reginald+Hickle&color=000&background=EBF4FF",
                        "phone_number": "830.674.0491",
                        "email": "brook55@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvdf4e3nbmqsp5pd5ztvxx",
                        "user_shift_id": "01jvdvea0dpqhzqpjgmafzh6m5",
                        "name": "Kailey Rice",
                        "avatar_url": "https://ui-avatars.com/api/?name=Kailey+Rice&color=000&background=EBF4FF",
                        "phone_number": "+13076137080",
                        "email": "phermiston@example.org",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    },
                    {
                        "user_id": "01jvdvdezss51vbs2fkg46q85a",
                        "user_shift_id": "01jvdvea0za1yj7tp1h2rk6yrm",
                        "name": "Roberta Batz V",
                        "avatar_url": "https://ui-avatars.com/api/?name=Roberta+Batz+V&color=000&background=EBF4FF",
                        "phone_number": "(714) 827-1484",
                        "email": "gutmann.nora@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "pending"
                    },
                    {
                        "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
                        "user_shift_id": "01jvjfnkftczzxrdzgxxyp8v0y",
                        "name": "Company Admin",
                        "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                        "phone_number": "1234567892",
                        "email": "companyadmin@example.com",
                        "user_shift_status": "arrived",
                        "shift_request_status": "confirmed"
                    }
                ]
            }
        ],
        "venue": {
            "id": "01jvdve26hj45wdj0gbaxc6vdm",
            "venue_name": "Venue #1",
            "venue_type": [
                "venue"
            ],
            "venue_color": "gray",
            "venue_comment": "",
            "address": "89941 Cassin Mission\nPort Shanonhaven, NY 01401-0070",
            "latitude": "29.767544",
            "longitude": "-95.362125"
        }
    },
    {
        "id": "01jve1tcm8n9vbv25t5p2bta1c",
        "shift-request-id": "01jve1vn3qn9edcw2cpz5rfaf7",
        "shift_id": "01jve1tckhx0wvr3xxns7fkp99",
        "schedule_id": "01jve1tcj0gmxhfynfq84gcrqv",
        "schedule_worker_notes": null,
        "schedule_admin_notes": null,
        "venue_id": "01jvdve26hj45wdj0gbaxc6vdm",
        "venue_name": "Venue #1",
        "title": "Audio Visual Specialist",
        "schedule_title": "Fuck",
        "can_punch": false,
        "can_bailout": false,
        "call_time": 30,
        "start_time": "2025-05-16T15:00:00.000000Z",
        "end_time": "2025-05-16T19:00:00.000000Z",
        "timePunches": [],
        "worker_notes": null,
        "admin_notes": null,
        "workers": [
            {
                "shift_id": "01jve1tckhx0wvr3xxns7fkp99",
                "shift_name": "Audio Visual Specialist",
                "start_time": "2025-05-16T15:00:00.000000Z",
                "end_time": null,
                "worker_count": 1,
                "workers": [
                    {
                        "user_id": "01jvdvd9kxg21gcp2wvc1jcnsv",
                        "user_shift_id": "01jve1tcm8n9vbv25t5p2bta1c",
                        "name": "Company Admin",
                        "avatar_url": "https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF",
                        "phone_number": "1234567892",
                        "email": "companyadmin@example.com",
                        "user_shift_status": null,
                        "shift_request_status": "confirmed"
                    }
                ]
            }
        ],
        "venue": {
            "id": "01jvdve26hj45wdj0gbaxc6vdm",
            "venue_name": "Venue #1",
            "venue_type": [
                "venue"
            ],
            "venue_color": "gray",
            "venue_comment": "",
            "address": "89941 Cassin Mission\nPort Shanonhaven, NY 01401-0070",
            "latitude": "29.767544",
            "longitude": "-95.362125"
        }
    }
]
```

## Page Functionality

### Login Page
- Users authenticate with email and password
- Successful login redirects to Dashboard
- Failed login shows error message

### Models
- There should be 3 model types 
- HalfScreen; this will slide up from the bottom of the screen to take up half to 2/3's of the page with a drag bar that allows the user to drag the model closed or to take up the full screen of back to its original state, the user can also click outside of it to close
- Contained: this is a page that slide in from the left or right of the page taking up the full screen with a header and back/close botton on top. the user should be able to slide to close the model from either side of the screen in a fading action like Snapchat
- Popup: this is a popup confirmation model to ask if the user is sure about the action, this needs the ability to have a title, description, and to add content, or change the actions (cancel, confirm)  

### Dashboard
- Welcome Message using the current users name on top 
- under the welcome there should be two actions (ShiftRequest, and AvailabileShifts), These actions when clicked should open a uncontined model* showing the shiftRequest, and AvailabileShifts pages respectively. there should also be a badge on the action stating how many shiftRequests, or Available Shifts there are for the user
- Week Calendar with week change selectors on either side of a calendar lable stating the current month and year, when a new day is selected or week has been changed a return icon will appear resetting the calendar to the current day. 
- the current day will be determained by a rounded different color background, when a new day is selected it will match this same background and the current day will get a dotted outline 
- The Calendar's data should be populated through the calendar API endpoint, When there an en event for that day a colored dot will show up under the date repesinting a single userShift, if there are multiple userShifts there will be multiple dots but depending on the shift_request Status on the shift the dot will be a different color (confirmed => green , pending => gold),if there are timeOff or Availability it should show a bar for each above the date on top of each other, timeOff will be red and Availability will be gray
-When a selected date has records (data) it will then show that data on a seperate card with the current date as the title, the timeOff and Availability should be under the title on top of eachother with thin bars with their respective colors and title with the time specified in the API, then if there are any userShifts it should use the shiftDetails component to display the shift details, actions, and so on. if there are no userShifts for that day just have it be an emoty box stating such

### My Shifts
- Tab navigation between upcoming and past shifts
- For each upcoming shift:
  - Display shift title, schedule title, start/end time, Call time ,venue
  - Allow actions: Time punch (clock in/out), bailout (request replacement)
  - Show shift details in a modal with the same actions
- For each past shift:
  - Display role, date, time, location
  - Show hours worked

### Chats
- List of all conversations
- Indication of unread messages
- Online status indicator
- Search functionality
- Messaging interface with text input and send button

### Availability
- Calendar view (allowing for single or range day selections) showing the current month, when there is a record for that day it will have a gray bar that, if there was another day next to it it would look connected visually.
- if a day without a record was selected a new card under the calendar title would show us stating the number of days selected. cancle, submit actions. 
    - when submitting a new availability it will open a new model with a form (time selector, date selector, text area, toggle (to see if its recurrence), and an incermant for recurrence_limit)
- if a day with a record was selected a model should open displaying that Availabilitys details, actions to edit, delete, or close

### My Time Off
- Form to request time off with date range and reason
- List of pending requests
- History of approved/denied requests
- Option to cancel pending requests

### My Hours
- Current pay period summary
- Previous pay periods
- Detailed view of hours worked by day
- Export functionality for records

### Shift Requests
- List of available shifts that need coverage
- Action to request to take a shift

## Actions and Workflows

### Request Action 
1. user click Request
2. Api ran, Toast notification shown

### Time Punch Process
1. User clicks "Punch In" button on active shift
2. System records time and location
3. Shift status updates to "in progress"
4. "Punch In" button changes to "Punch Out"

### Bailout Process
1. User requests bailout on a shift
2. popup model asking to confirm with a form
3. User provides reason inside model form
4. API processes and refresh

### Time Off Request Process
1. User submits time off request with dates and reason
2. Request appears in pending status
3. Manager reviews and approves/denies
4. User receives notification of decision
5. If approved, dates are blocked in scheduling system

## Notes for Development

1. All API calls should use real endpoints, not mock data
2. Remember multi-tenant structure - all data is team-specific
3. Implement proper error handling for all API calls
4. Use loading states for better UX during API calls
5. Implement toast notifications for actions (success/error)
6. Ensure mobile-first responsive design
7. Use
8. Implement proper authentication token refresh mechanism
9. Consider implementing offline capabilities for time punches 