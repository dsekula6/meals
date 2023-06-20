- dodavanje testnih podataka kroz fixtures
- popravljen return u controlleru
- napravljen service u kojem se nalaze funkcije za obrađivanje jela i jsona
- dodana funkcionalnost u query-u diff_time


u MealsController.php se nalazi, 

1. route
koji je endpoint za pregled svih jela i ima dva returna
od kojih
   - jedan vraća JSON response kako je pokazano u zadatku
   - drugi vraća VIEW u kojem je prikazano isto to sa malo front enda


u .gitignore datoteci se nalaze datoteke koje nisu uploadane radi veličine uploada a uvijek dolaze sa symfony projektom


primjer JSON responsa za query
/meals?page=1&per_page=20&with=category,tags&lang=hr&diff_time=10

JSON:
{
    "meta": {
        "page": 1,
        "per_page": 20,
        "total_pages": 3,
        "total_items": 49
    },
    "data": [
        {
            "id": 1107,
            "title": "HRVreiciendis occaecati",
            "description": "HRVAmet est magnam et temporibus distinctio delectus. Aut ea totam qui. Porro et et perferendis amet earum nemo.",
            "status": "created",
            "category": {
                "id": 257,
                "title": "KATEGORIJA8",
                "slug": "cat-8"
            },
            "tags": [
                {
                    "id": 140,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 146,
                    "title": "HRVtag7",
                    "slug": "tag-7"
                }
            ]
        },
        {
            "id": 1108,
            "title": "HRVquia sed",
            "description": "HRVEt repellat veniam facilis eum aliquam. Illo aliquam veniam quaerat veritatis est cupiditate numquam quia. Est nihil incidunt facere fuga a consequatur ea.",
            "status": "created",
            "category": {
                "id": 255,
                "title": "KATEGORIJA6",
                "slug": "cat-6"
            },
            "tags": [
                {
                    "id": 148,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                },
                {
                    "id": 149,
                    "title": "HRVtag10",
                    "slug": "tag-10"
                }
            ]
        },
        {
            "id": 1109,
            "title": "HRVdolores reiciendis",
            "description": "HRVOmnis alias nihil dolorem autem impedit voluptatem reprehenderit voluptate. Corrupti est veniam autem eaque maxime nobis assumenda. Est unde voluptas aspernatur sed. Error amet nostrum id enim.",
            "status": "created",
            "category": {
                "id": 253,
                "title": "KATEGORIJA4",
                "slug": "cat-4"
            },
            "tags": [
                {
                    "id": 147,
                    "title": "HRVtag8",
                    "slug": "tag-8"
                },
                {
                    "id": 148,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                }
            ]
        },
        {
            "id": 1110,
            "title": "HRVipsum officiis",
            "description": "HRVDignissimos numquam quo nihil. Omnis aut officia esse aut error. Et non et maxime quos. Praesentium dolorem labore quisquam aut.",
            "status": "created",
            "category": {
                "id": 258,
                "title": "KATEGORIJA9",
                "slug": "cat-9"
            },
            "tags": [
                {
                    "id": 141,
                    "title": "HRVtag2",
                    "slug": "tag-2"
                },
                {
                    "id": 143,
                    "title": "HRVtag4",
                    "slug": "tag-4"
                }
            ]
        },
        {
            "id": 1111,
            "title": "HRVodit ut",
            "description": "HRVFacilis inventore et iste perspiciatis sunt. Et optio qui quis ab eum labore cum. Consectetur modi qui fuga nisi minima corporis ut. Veritatis et culpa voluptas et vitae ut.",
            "status": "created",
            "category": {
                "id": 252,
                "title": "KATEGORIJA3",
                "slug": "cat-3"
            },
            "tags": [
                {
                    "id": 144,
                    "title": "HRVtag5",
                    "slug": "tag-5"
                },
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                }
            ]
        },
        {
            "id": 1112,
            "title": "HRVnam perferendis",
            "description": "HRVFuga dolorum possimus porro debitis animi officiis ea. Aut fugiat odio accusantium ducimus rerum incidunt. Illo est porro et harum corrupti. Et ipsum qui voluptas aut non.",
            "status": "created",
            "category": {
                "id": 256,
                "title": "KATEGORIJA7",
                "slug": "cat-7"
            },
            "tags": [
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                },
                {
                    "id": 147,
                    "title": "HRVtag8",
                    "slug": "tag-8"
                }
            ]
        },
        {
            "id": 1113,
            "title": "HRVsed recusandae",
            "description": "HRVId inventore vel enim. Unde ipsum magni et fugit sapiente maiores. Sint suscipit deserunt voluptatibus rem.",
            "status": "created",
            "category": {
                "id": 251,
                "title": "KATEGORIJA2",
                "slug": "cat-2"
            },
            "tags": [
                {
                    "id": 140,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 144,
                    "title": "HRVtag5",
                    "slug": "tag-5"
                }
            ]
        },
        {
            "id": 1114,
            "title": "HRVquaerat odio",
            "description": "HRVDolores quam doloribus harum voluptatem. Eos cum iste voluptatem est ab.",
            "status": "created",
            "category": {
                "id": 258,
                "title": "KATEGORIJA9",
                "slug": "cat-9"
            },
            "tags": [
                {
                    "id": 141,
                    "title": "HRVtag2",
                    "slug": "tag-2"
                },
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                }
            ]
        },
        {
            "id": 1115,
            "title": "HRVet accusamus",
            "description": "HRVEst aperiam molestias alias porro est optio quam. Vel tempore aut beatae. Ut ab voluptates reiciendis molestiae deserunt eum. Culpa eum laboriosam qui id ipsa fugit.",
            "status": "created",
            "category": {
                "id": 253,
                "title": "KATEGORIJA4",
                "slug": "cat-4"
            },
            "tags": [
                {
                    "id": 141,
                    "title": "HRVtag2",
                    "slug": "tag-2"
                },
                {
                    "id": 144,
                    "title": "HRVtag5",
                    "slug": "tag-5"
                }
            ]
        },
        {
            "id": 1116,
            "title": "HRVquis odit",
            "description": "HRVCum voluptas molestiae est nulla quasi omnis. Officiis blanditiis at dolor repellendus. Voluptatum voluptas eos consequuntur sequi consequuntur sit. Quaerat quasi omnis nemo cupiditate.",
            "status": "created",
            "category": {
                "id": 251,
                "title": "KATEGORIJA2",
                "slug": "cat-2"
            },
            "tags": [
                {
                    "id": 142,
                    "title": "HRVtag3",
                    "slug": "tag-3"
                },
                {
                    "id": 143,
                    "title": "HRVtag4",
                    "slug": "tag-4"
                }
            ]
        },
        {
            "id": 1117,
            "title": "HRVdolor accusamus",
            "description": "HRVEx cumque et doloremque quia reiciendis tenetur. Odit tenetur animi sint impedit. Iure sit cumque adipisci nisi excepturi. Ducimus quia et velit consequatur.",
            "status": "deleted",
            "category": {
                "id": 252,
                "title": "KATEGORIJA3",
                "slug": "cat-3"
            },
            "tags": [
                {
                    "id": 140,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 143,
                    "title": "HRVtag4",
                    "slug": "tag-4"
                }
            ]
        },
        {
            "id": 1118,
            "title": "HRVnostrum dicta",
            "description": "HRVAsperiores incidunt quo quidem et. Velit ea enim odit debitis qui illum qui. Ipsum harum illum id ipsam. Labore animi exercitationem ab consequatur voluptatem voluptas temporibus.",
            "status": "deleted",
            "category": {
                "id": 256,
                "title": "KATEGORIJA7",
                "slug": "cat-7"
            },
            "tags": [
                {
                    "id": 141,
                    "title": "HRVtag2",
                    "slug": "tag-2"
                },
                {
                    "id": 144,
                    "title": "HRVtag5",
                    "slug": "tag-5"
                }
            ]
        },
        {
            "id": 1119,
            "title": "HRVquasi porro",
            "description": "HRVUt molestias voluptatibus laboriosam et quis voluptatem. Et ducimus expedita optio. Sunt corrupti dolore quod ducimus nihil id. Asperiores voluptas ut porro et nobis iure.",
            "status": "deleted",
            "category": {
                "id": 257,
                "title": "KATEGORIJA8",
                "slug": "cat-8"
            },
            "tags": [
                {
                    "id": 140,
                    "title": "HRVtag1",
                    "slug": "tag-1"
                },
                {
                    "id": 142,
                    "title": "HRVtag3",
                    "slug": "tag-3"
                }
            ]
        },
        {
            "id": 1120,
            "title": "HRVaut quae",
            "description": "HRVSuscipit impedit similique in labore officiis. Qui inventore quia autem perspiciatis. Ut est maxime non ex consequatur aut. Laboriosam qui consequuntur tenetur est ipsam est.",
            "status": "deleted",
            "category": {
                "id": 259,
                "title": "KATEGORIJA10",
                "slug": "cat-10"
            },
            "tags": [
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                },
                {
                    "id": 148,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                }
            ]
        },
        {
            "id": 1121,
            "title": "HRVnumquam sed",
            "description": "HRVFugiat rerum et consequuntur quod omnis architecto quas. Voluptates eius labore debitis exercitationem nihil quo. Eos ipsam quae et iste exercitationem. Molestias nostrum asperiores veritatis iure deserunt.",
            "status": "deleted",
            "category": {
                "id": 255,
                "title": "KATEGORIJA6",
                "slug": "cat-6"
            },
            "tags": [
                {
                    "id": 144,
                    "title": "HRVtag5",
                    "slug": "tag-5"
                },
                {
                    "id": 148,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                }
            ]
        },
        {
            "id": 1122,
            "title": "HRVlaborum rerum",
            "description": "HRVNon quaerat quis aut hic beatae et dolorum. Voluptas voluptatibus dolor ut et earum perspiciatis ut. Non ab provident voluptatum aut.",
            "status": "deleted",
            "category": {
                "id": 251,
                "title": "KATEGORIJA2",
                "slug": "cat-2"
            },
            "tags": [
                {
                    "id": 144,
                    "title": "HRVtag5",
                    "slug": "tag-5"
                },
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                }
            ]
        },
        {
            "id": 1123,
            "title": "HRVlaboriosam voluptas",
            "description": "HRVSunt blanditiis aut magni tempora ab autem temporibus. Porro beatae ea quod iure. Ut quae dolor reiciendis minus voluptatum.",
            "status": "deleted",
            "category": {
                "id": 251,
                "title": "KATEGORIJA2",
                "slug": "cat-2"
            },
            "tags": [
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                },
                {
                    "id": 148,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                }
            ]
        },
        {
            "id": 1124,
            "title": "HRVconsectetur dolorum",
            "description": "HRVQui deserunt hic asperiores et modi dolores. Ut repudiandae qui recusandae eum omnis dolores sunt at.",
            "status": "deleted",
            "category": {
                "id": 253,
                "title": "KATEGORIJA4",
                "slug": "cat-4"
            },
            "tags": [
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                },
                {
                    "id": 147,
                    "title": "HRVtag8",
                    "slug": "tag-8"
                }
            ]
        },
        {
            "id": 1125,
            "title": "HRVeveniet aut",
            "description": "HRVVoluptatem impedit facere dolore placeat modi minus temporibus consequatur. Voluptas fugit voluptas molestiae dicta error.",
            "status": "deleted",
            "category": {
                "id": 254,
                "title": "KATEGORIJA5",
                "slug": "cat-5"
            },
            "tags": [
                {
                    "id": 141,
                    "title": "HRVtag2",
                    "slug": "tag-2"
                }
            ]
        },
        {
            "id": 1126,
            "title": "HRVautem velit",
            "description": "HRVQuasi aspernatur reiciendis deleniti odio illo et in id. Illum adipisci magni nobis est.",
            "status": "created",
            "category": {
                "id": 259,
                "title": "KATEGORIJA10",
                "slug": "cat-10"
            },
            "tags": [
                {
                    "id": 145,
                    "title": "HRVtag6",
                    "slug": "tag-6"
                },
                {
                    "id": 148,
                    "title": "HRVtag9",
                    "slug": "tag-9"
                }
            ]
        }
    ]
}
