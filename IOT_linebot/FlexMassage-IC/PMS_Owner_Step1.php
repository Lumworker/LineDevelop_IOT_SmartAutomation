

<?php
$jsonflex = [
  "type" => "flex",
  "altText" => "Flex Message",
  "contents" => [
    "type" => "bubble",
    "direction" => "ltr",
    "body" => [
      "type" => "box",
      "layout" => "vertical",
      "spacing" => "md",
      "contents" => [
        [
          "type" => "text",
          "text"=> "แจ้งยอดการผลิต : ".$trans_id,
          "weight" => "bold",
          "size" => "xl",
          "contents" => []
        ],
        [
          "type"=> "box",
          "layout"=> "vertical",
          "contents"=> [
            [
              "type"=> "text",
              "text"=> $Date,
              "contents"=> []
            ],
            [
              "type"=> "text",
              "text"=> "Owner",
              "size"=> "lg",
              "align"=> "end",
              "contents"=> []
            ]
          ]
        ],
        [
          "type" => "box",
          "layout" => "vertical",
          "spacing" => "sm",
          "contents" => [
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "หลอดใหญ่",
                  "weight" => "bold",
                  "margin" => "sm",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "B - กระสอบ",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $B . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "PB - แพ็คใหญ่",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $PB . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "P2 - เบล",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $P2 . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "PC-B - ใหญ่โม่",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $PC_B . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "R - เศษใหญ่โม่",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $R . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "จำนวนรอบการเดินเครื่อง  " . $Cycle_B . " รอบ",
                  "weight" => "bold",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ]
              ]
                ],
          ]
        ],
        [
          "type" => "separator"
        ],
        [
          "type" => "box",
          "layout" => "vertical",
          "spacing" => "sm",
          "contents" => [
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "หลอดเล็ก",
                  "weight" => "bold",
                  "margin" => "sm",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "S - กระสอบ",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $S . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "PS - แพ็คใหญ่",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $PS . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "PC-S - เล็กโม่",
                  "flex" => 0,
                  "margin" => "sm",
                  "contents" => []
                ],
                [
                  "type" => "text",
                  "text" => $PC_S . " ถุง",
                  "size" => "md",
                  "color" => "#000000FF",
                  "align" => "end",
                  "contents" => []
                ]
              ]
                ],
                [
                  "type" => "box",
                  "layout" => "baseline",
                  "contents" => [
                    [
                      "type" => "text",
                      "text" => "จำนวนรอบการเดินเครื่อง   " . $Cycle_S . " รอบ",
                      "weight" => "bold",
                      "flex" => 0,
                      "margin" => "sm",
                      "contents" => []
                    ],
                  ]
                ],
          ]
        ],
        [
          "type" => "text",
          "text" => "กรุณาตรวจสอบ ความถูกต้อง",
          "size" => "xxs",
          "color" => "#AAAAAA",
          "wrap" => true,
          "contents" => []
        ],
        [
          "type" => "separator"
        ]
      ]
    ]
  ]
];
