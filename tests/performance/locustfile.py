from locust import HttpUser, task, between, TaskSet, events
import random
import json
import time

# Performance thresholds
THRESHOLDS = {
    'homepage': 200,  # 200ms
    'admin_pages': 500,  # 500ms
    'file_upload': 2000,  # 2s
}

@events.request.add_listener
def check_response_time(request_type, name, response_time, response_length, exception, **kwargs):
    """Monitor response times against thresholds"""
    if exception:
        return
    
    threshold = None
    if name == '/':
        threshold = THRESHOLDS['homepage']
    elif name.startswith('/admin'):
        threshold = THRESHOLDS['admin_pages']
    elif 'upload' in name:
        threshold = THRESHOLDS['file_upload']
    
    if threshold and response_time > threshold:
        print(f"WARNING: {name} response time ({response_time}ms) exceeded threshold ({threshold}ms)")

class AdminUserBehavior(TaskSet):
    def on_start(self):
        """Login as admin user"""
        with self.client.post("/login", {
            "email": "admin@example.com",
            "password": "password"
        }, catch_response=True) as response:
            if response.status_code != 200:
                response.failure("Login failed")
    
    @task(1)
    def visit_admin_settings(self):
        """Test admin settings page load"""
        start_time = time.time()
        with self.client.get("/admin/settings", catch_response=True) as response:
            response_time = (time.time() - start_time) * 1000
            if response.status_code != 200:
                response.failure(f"Admin settings page failed with status code: {response.status_code}")
            elif response_time > THRESHOLDS['admin_pages']:
                response.failure(f"Response time ({response_time}ms) exceeded threshold ({THRESHOLDS['admin_pages']}ms)")
    
    @task(1)
    def update_settings(self):
        """Test settings update with file upload"""
        files = {
            'site_logo': ('logo.png', open('test_files/logo.png', 'rb'), 'image/png'),
            'site_favicon': ('favicon.ico', open('test_files/favicon.ico', 'rb'), 'image/x-icon')
        }
        data = {
            'site_title': 'Chemico Test',
            'contact_email': 'test@example.com',
            'contact_phone': '+1234567890',
            'contact_address': '123 Test Street'
        }
        start_time = time.time()
        with self.client.post("/admin/settings", data=data, files=files, catch_response=True) as response:
            response_time = (time.time() - start_time) * 1000
            if response.status_code != 200:
                response.failure(f"Settings update failed with status code: {response.status_code}")
            elif response_time > THRESHOLDS['file_upload']:
                response.failure(f"File upload time ({response_time}ms) exceeded threshold ({THRESHOLDS['file_upload']}ms)")

class RegularUserBehavior(TaskSet):
    @task(3)
    def visit_home(self):
        """Test homepage load"""
        start_time = time.time()
        with self.client.get("/", catch_response=True) as response:
            response_time = (time.time() - start_time) * 1000
            if response.status_code != 200:
                response.failure(f"Homepage failed with status code: {response.status_code}")
            elif response_time > THRESHOLDS['homepage']:
                response.failure(f"Homepage response time ({response_time}ms) exceeded threshold ({THRESHOLDS['homepage']}ms)")
    
    @task(2)
    def visit_products(self):
        """Test products page load"""
        with self.client.get("/products", catch_response=True) as response:
            if response.status_code != 200:
                response.failure(f"Products page failed with status code: {response.status_code}")
    
    @task(1)
    def visit_contact(self):
        """Test contact page load"""
        with self.client.get("/contact", catch_response=True) as response:
            if response.status_code != 200:
                response.failure(f"Contact page failed with status code: {response.status_code}")

class WebsiteUser(HttpUser):
    wait_time = between(1, 5)
    tasks = {RegularUserBehavior: 4, AdminUserBehavior: 1}
