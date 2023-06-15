u MealsController.php se nalazi dva routa, 

1. route
koji je endpoint za pregled svih jela i ima dva returna
od kojih
   - jedan vraća JSON response kako je pokazano u zadatku
   - drugi vraća VIEW u kojem je prikazano isto to sa malo front enda

2. route
koji sam koristio za kreiranje testnih podataka
sadrži zakomentirane komade koda koji služe za dodavanje testnih podataka

u .gitignore datoteci se nalaze datoteke koje nisu uploadane radi veličine uploada a uvijek dolaze sa symfony project new

u repozitoriju se nalazi jelaDatabaseDump.sql što su bili moji testni podaci do trenutka uploadanja

primjer JSON responsa za query
index.php/meals?page=1&per_page=4&tags=1&with=tags,ingredients,category&lang=hr

JSON:
{
    "meta": {
        "page": 1,
        "per_page": 4,
        "total_pages": 3,
        "total_items": 9
    },
    "data": [
        {
            "id": 35,
            "title": "HRVut et",
            "description": "HRVIpsum et quas autem. Rerum nihil veritatis animi sit harum voluptates perferendis veritatis. Eos temporibus est quaerat illo velit. Repellat magnam alias asperiores aperiam.",
            "ingredients": [
                {
                    "id": 3,
                    "title": "HRVnumquam",
                    "slug": "numquam"
                },
                {
                    "id": 6,
                    "title": "HRVid",
                    "slug": "id"
                },
                {
                    "id": 8,
                    "title": "HRVsunt",
                    "slug": "sunt"
                }
            ],
            "category": {
                "id": 3,
                "title": "KATEGORIJA3",
                "slug": "cat-3"
            },
            "tags": [
                {
                    "id": 1,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 7,
                    "title": "HRVtag7",
                    "slug": "tag-7"
                }
            ]
        },
        {
            "id": 37,
            "title": "HRVest facere",
            "description": "HRVEt unde facere sed nihil. Doloribus est animi animi rem tenetur. Non fuga quod inventore a perferendis.",
            "ingredients": [
                {
                    "id": 3,
                    "title": "HRVnumquam",
                    "slug": "numquam"
                },
                {
                    "id": 4,
                    "title": "HRVut",
                    "slug": "ut"
                }
            ],
            "category": {
                "id": 8,
                "title": "KATEGORIJA8",
                "slug": "cat-8"
            },
            "tags": [
                {
                    "id": 1,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 4,
                    "title": "HRVtag4",
                    "slug": "tag-4"
                }
            ]
        },
        {
            "id": 42,
            "title": "HRVconsequuntur at",
            "description": "HRVNihil dolorem voluptas reiciendis quod voluptas. Ut nihil aliquam dolores laudantium iure. Non officiis quia laboriosam molestiae repellat repellendus.",
            "ingredients": [
                {
                    "id": 6,
                    "title": "HRVid",
                    "slug": "id"
                },
                {
                    "id": 7,
                    "title": "HRVsed",
                    "slug": "sed"
                }
            ],
            "category": {
                "id": 7,
                "title": "KATEGORIJA7",
                "slug": "cat-7"
            },
            "tags": [
                {
                    "id": 1,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 4,
                    "title": "HRVtag4",
                    "slug": "tag-4"
                }
            ]
        },
        {
            "id": 45,
            "title": "HRVut explicabo",
            "description": "HRVTemporibus sunt molestias ducimus dolores est et. Blanditiis dolorum consequatur quia hic aut ea. Eveniet qui quae dicta in aspernatur tempore. Iste error et voluptatibus eveniet.",
            "ingredients": [
                {
                    "id": 2,
                    "title": "HRVdolore",
                    "slug": "dolore"
                },
                {
                    "id": 6,
                    "title": "HRVid",
                    "slug": "id"
                },
                {
                    "id": 7,
                    "title": "HRVsed",
                    "slug": "sed"
                }
            ],
            "category": {
                "id": 5,
                "title": "KATEGORIJA5",
                "slug": "cat-5"
            },
            "tags": [
                {
                    "id": 1,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 9,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                }
            ]
        }
    ]
}
