# Performance Testing Guide

This directory contains performance tests for the Chemico website using Locust.

## Setup

1. Install the required dependencies:
```bash
pip install -r ../performance_requirements.txt
```

2. Add test files for file upload testing:
```bash
# Add a test logo and favicon to tests/performance/test_files/
cp your_test_logo.png tests/performance/test_files/logo.png
cp your_test_favicon.ico tests/performance/test_files/favicon.ico
```

3. Update admin credentials in locustfile.py:
```python
self.client.post("/login", {
    "email": "your_admin_email@example.com",
    "password": "your_admin_password"
})
```

## Running Tests

1. Start your Laravel application locally:
```bash
php artisan serve
```

2. In a new terminal, start Locust:
```bash
cd tests/performance
locust
```

3. Open your browser and go to http://localhost:8089

4. Configure your test:
   - Number of users: Start with 50
   - Spawn rate: 10 users/second
   - Host: http://localhost:8000 (or your application URL)

## Test Scenarios

The performance tests simulate two types of users:

### Regular Users (80% of traffic)
- Homepage load testing (weight: 3)
- Products page testing (weight: 2)
- Contact page testing (weight: 1)
- API endpoints testing (weight: 1)

### Admin Users (20% of traffic)
- Admin settings page load
- Settings update with file uploads
  - Logo upload
  - Favicon upload
  - Site information update

## Interpreting Results

Locust provides real-time statistics including:
- Response time (min, max, average)
- Requests per second
- Failure rate
- Number of users

Key metrics to monitor:
1. Response Times:
   - Homepage: Should be < 200ms
   - Admin pages: Should be < 500ms
   - File uploads: Should be < 2s

2. Error Rates:
   - Should be < 1% for all endpoints
   - Monitor file upload failures separately

3. Throughput:
   - Track requests per second
   - Monitor concurrent user capacity

## Best Practices

1. Start with a small number of users and gradually increase
2. Monitor your server resources during tests:
   - CPU usage
   - Memory consumption
   - Database connections
   - File system operations
3. Run tests multiple times to get consistent results
4. Test during off-peak hours in development/staging environments
5. Pay special attention to file upload performance
6. Monitor database query performance during admin operations
