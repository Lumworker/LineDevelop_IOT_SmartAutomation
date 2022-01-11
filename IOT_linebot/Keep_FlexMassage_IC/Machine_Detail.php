<?php
$jsonflex=
[
    "type"=> "flex",
    "altText"=> "Flex Message",
    "contents"=> [
      "type"=> "bubble",
      "direction"=> "ltr",
      "hero"=> [
        "type"=> "image",
        "url"=> "https://sv1.picz.in.th/images/2019/06/05/1YNDAu.png",
        "size"=> "full",
        "aspectRatio"=> "1.51:1",
        "aspectMode"=> "fit"
      ],
      "body"=> [
        "type"=> "box",
        "layout"=> "vertical",
        "spacing"=> "xs",
        "contents"=> [
          [
            "type"=> "text",
            "text"=> "$massage[2]",
            "size"=> "xl",
            "align"=> "start",
            "weight"=> "bold"
          ],
          [
            "type"=> "text",
            "text"=> "ข้อมูลแบบละเอียด",
            "size"=> "lg",
            "align"=> "start",
            "weight"=> "bold"
          ]
        ]
      ],
      "footer"=> [
        "type"=> "box",
        "layout"=> "vertical",
        "spacing"=> "sm",
        "contents"=> [
          [
            "type"=> "button",
            "action"=> [
              "type"=> "message",
              "label"=> "รอบการทำงาน",
              "text"=> "รอบการทำงาน : $massage[1]"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ],
          [
            "type"=> "button",
            "action"=> [
              "type"=> "message",
              "label"=> "พลังงานที่ใช้",
              "text"=> "พลังงานที่ใช้ : $massage[1]"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ],
          [
            "type"=> "button",
            "action"=> [
              "type"=> "message",
              "label"=> "ปริมาณน้ำที่ใช้",
              "text"=> "ปริมาณน้ำที่ใช้ : $massage[1]"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ],
          [
            "type"=> "button",
            "action"=> [
              "type"=> "message",
              "label"=> "เวลาที่น้ำแข็งรอบต่อไปจะตก",
              "text"=> "เวลาที่น้ำแข็งรอบต่อไปจะตก : $massage[1]"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ],
          [
            "type"=> "button",
            "action"=> [
              "type"=> "message",
              "label"=> "อุณหภูมิการทำน้ำแข็ง",
              "text"=> "อุณหภูมิการทำน้ำแข็ง : $massage[1]"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ],
          [
            "type"=> "button",
            "action"=> [
              "type"=> "message",
              "label"=> "สถานะของเครื่อง",
              "text"=> "สถานะของเครื่อง : $massage[1]"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ],
          [
            "type"=> "button",
            "action"=> [
              "type"=> "uri",
              "label"=> "คู่มือการใช้งาน",
              "uri"=> "https://drive.google.com/open?id=1jUistGCnKDDiq7McyK6PWtR1CfFL5nmX"
            ],
            "color"=> "#0F4DB6",
            "height"=> "sm",
            "style"=> "primary"
          ]
        ]
      ]
    ]
  ]


?>