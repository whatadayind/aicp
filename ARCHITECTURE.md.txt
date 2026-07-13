# AICP Architecture

## Overview

AICP (AI Customer Engagement Platform) is a modular, API-first SaaS application built with Laravel and React.

The platform is designed to be scalable, maintainable, and cloud-ready while remaining simple enough for a small team to develop.

---

# High-Level Architecture

```
                React Frontend
                      │
                 REST API
                      │
               Laravel Backend
                      │
      ┌───────────────┼───────────────┐
      │               │               │
 PostgreSQL        Redis         Mailpit
```

---

# Technology Stack

## Backend

- Laravel 12
- PHP 8.5
- Laravel Sanctum
- Laravel Queues

## Frontend

- React
- TypeScript
- Vite

## Database

- PostgreSQL

## Cache & Queue

- Redis

## Email

- Mailpit (Development)
- SMTP Providers (Production)

## Development

- Docker Desktop
- Laravel Sail
- Git
- GitHub

---

# Project Structure

```
AICP
│
├── apps
│   ├── api
│   └── web
│
├── docs
├── docker
├── infrastructure
└── scripts
```

---

# Architecture Principles

## 1. API-First

All business logic lives in the Laravel API.

The frontend communicates only through HTTP APIs.

---

## 2. Modular Design

Features are organized into modules.

Examples:

- Authentication
- Organizations
- Contacts
- Campaigns
- Automation
- AI

Modules should be independent where practical.

---

## 3. Single Responsibility

Classes should have one responsibility.

Avoid large controllers and move business logic into services or actions when appropriate.

---

## 4. Docker-First Development

Every developer should be able to clone the repository and start the project using Docker.

No machine-specific configuration should be required.

---

## 5. Feature-Driven Development

Each feature should include:

- Database changes
- Models
- API
- Validation
- Business logic
- Tests
- Documentation

---

## 6. Testing

Every major feature should include automated tests.

Testing strategy:

- Feature Tests
- Unit Tests

---

## 7. Security

- Authentication using Laravel Sanctum
- Password hashing
- CSRF protection
- Input validation
- Authorization policies

---

# Future Architecture

As AICP grows, modules may be extracted into separate packages or microservices if required.

The initial implementation will remain a **Modular Monolith**, which provides simplicity while allowing future scalability.

---

# Development Workflow

Requirement
↓
Design
↓
Database
↓
Backend
↓
Frontend
↓
Testing
↓
Documentation
↓
Git Commit
↓
GitHub Push

---

# Coding Standards

- PSR-12
- Laravel Best Practices
- Conventional Commits
- Small Pull Requests
- Code Reviews (future)