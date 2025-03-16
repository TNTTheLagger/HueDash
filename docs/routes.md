# API Routes Documentation

## Topics

### Get All Topics
**Route:** `GET /topics`

**Description:** Retrieve all topics.

**Response:**
```json
[
    {
        "id": 1,
        "name": "Topic1",
        "created_at": "2023-10-01T00:00:00.000000Z",
        "updated_at": "2023-10-01T00:00:00.000000Z"
    },
    {
        "id": 2,
        "name": "Topic2",
        "created_at": "2023-10-01T00:00:00.000000Z",
        "updated_at": "2023-10-01T00:00:00.000000Z"
    }
]
```

### Create a New Topic
**Route:** `POST /topics`

**Description:** Create a new topic.

**Request Body:**
```json
{
    "name": "New Topic"
}
```

**Response:**
```json
{
    "id": 3,
    "name": "New Topic",
    "created_at": "2023-10-01T00:00:00.000000Z",
    "updated_at": "2023-10-01T00:00:00.000000Z"
}
```

### Delete a Topic
**Route:** `DELETE /topics/{id}`

**Description:** Delete a topic by ID.

**Response:** `204 No Content`

## Cards

### Get All Cards
**Route:** `GET /cards`

**Description:** Retrieve all cards. Optionally filter by topic.

**Query Parameters:**
- `topic` (optional): The name of the topic to filter by.

**Response:**
```json
[
    {
        "id": 1,
        "title": "Card Title 1",
        "body": "Card Body 1",
        "urgency": "high",
        "topic_id": 1,
        "created_at": "2023-10-01T00:00:00.000000Z",
        "updated_at": "2023-10-01T00:00:00.000000Z"
    },
    {
        "id": 2,
        "title": "Card Title 2",
        "body": "Card Body 2",
        "urgency": "medium",
        "topic_id": null,
        "created_at": "2023-10-01T00:00:00.000000Z",
        "updated_at": "2023-10-01T00:00:00.000000Z"
    }
]
```

### Create a New Card
**Route:** `POST /cards`

**Description:** Create a new card.

**Request Body:**
```json
{
    "title": "New Card",
    "body": "Card Body",
    "urgency": "low",
    "topic_id": 1
}
```

**Response:**
```json
{
    "id": 3,
    "title": "New Card",
    "body": "Card Body",
    "urgency": "low",
    "topic_id": 1,
    "created_at": "2023-10-01T00:00:00.000000Z",
    "updated_at": "2023-10-01T00:00:00.000000Z"
}
```

### Delete a Card
**Route:** `DELETE /cards/{id}`

**Description:** Delete a card by ID.

**Response:** `204 No Content`

## Dashboard

### View Dashboard
**Route:** `GET /`

**Description:** View the dashboard.

**Response:** HTML page with the dashboard.

### View Dashboard Filtered by Topic
**Route:** `GET /filter/{topic}`

**Description:** View the dashboard filtered by a specific topic.

**Response:** HTML page with the dashboard filtered by the specified topic.
