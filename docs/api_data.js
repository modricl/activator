define({ "api": [
  {
    "type": "get",
    "url": "/activator/code/generate",
    "title": "Get activation code",
    "name": "GenerateCode",
    "version": "1.0.0",
    "group": "Activator",
    "description": "<p>Method is used for generating and fetching activation code from server.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>provided API key</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "action",
            "description": "<p>action uid</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n{\n    \"action\": \"user7723-purchase-sport\",\n    \"code\": 2516,\n    \"expiry\": \"2021-10-29T08:47:03.664270Z\",\n    \"updated_at\": \"2021-10-29 08:37:03\",\n    \"created_at\": \"2021-10-29 08:37:03\",\n    \"id\": 25\n}",
          "type": "json"
        }
      ]
    },
    "filename": "src/Http/Controllers/ActivatorController.php",
    "groupTitle": "Activator"
  },
  {
    "type": "post",
    "url": "/activator/code/validate",
    "title": "Validate activation code",
    "name": "ValidateCode",
    "version": "1.0.0",
    "group": "Activator",
    "description": "<p>Method is used for activation code validation.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>provided API key</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "action",
            "description": "<p>action uid</p>"
          }
        ]
      }
    },
    "body": [
      {
        "group": "Body",
        "type": "Number",
        "optional": false,
        "field": "code",
        "description": "<p>activation code</p>"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n{\n    \"action\": \"user7723-purchase-sport\",\n    \"success\": \"true\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "    HTTP/1.1 200 OK\n{\n    \"error\": {\n        \"message\": \"Invalid Code\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "src/Http/Controllers/ActivatorController.php",
    "groupTitle": "Activator"
  }
] });
