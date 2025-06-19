"""
EspoCRM AI Agent Integration Example
This shows how AI agents can interact with EspoCRM REST API
"""

import requests
import json
from datetime import datetime, timedelta

class EspoCRMAgent:
    def __init__(self, base_url, username, password):
        self.base_url = base_url.rstrip('/') + '/api/v1'
        self.auth = (username, password)
        self.headers = {'Content-Type': 'application/json'}
    
    def create_lead(self, first_name, last_name, email, phone=None):
        """Create a new lead in the CRM"""
        data = {
            'firstName': first_name,
            'lastName': last_name,
            'emailAddress': email,
            'phoneNumber': phone,
            'status': 'New'
        }
        response = requests.post(
            f'{self.base_url}/Lead',
            json=data,
            auth=self.auth,
            headers=self.headers
        )
        return response.json()
    
    def schedule_service_appointment(self, contact_id, service_type, date_time):
        """Schedule a home service appointment as a meeting"""
        data = {
            'name': f'{service_type} Service Appointment',
            'dateStart': date_time.isoformat(),
            'dateEnd': (date_time + timedelta(hours=2)).isoformat(),
            'contactsIds': [contact_id],
            'status': 'Planned',
            'description': f'Home service appointment for {service_type}'
        }
        response = requests.post(
            f'{self.base_url}/Meeting',
            json=data,
            auth=self.auth,
            headers=self.headers
        )
        return response.json()
    
    def create_service_task(self, assigned_user_id, service_details):
        """Create a task for service technician"""
        data = {
            'name': service_details['title'],
            'status': 'Not Started',
            'priority': service_details.get('priority', 'Normal'),
            'assignedUserId': assigned_user_id,
            'dateEnd': service_details['due_date'].isoformat(),
            'description': service_details['description']
        }
        response = requests.post(
            f'{self.base_url}/Task',
            json=data,
            auth=self.auth,
            headers=self.headers
        )
        return response.json()
    
    def get_upcoming_appointments(self, days=7):
        """Get upcoming service appointments"""
        where = [{
            'type': 'after',
            'attribute': 'dateStart',
            'value': datetime.now().isoformat()
        }, {
            'type': 'before',
            'attribute': 'dateStart',
            'value': (datetime.now() + timedelta(days=days)).isoformat()
        }]
        
        params = {
            'where': json.dumps(where),
            'orderBy': 'dateStart',
            'order': 'asc'
        }
        response = requests.get(
            f'{self.base_url}/Meeting',
            params=params,
            auth=self.auth
        )
        return response.json()
    
    def update_task_status(self, task_id, status):
        """Update task completion status"""
        data = {'status': status}
        response = requests.patch(
            f'{self.base_url}/Task/{task_id}',
            json=data,
            auth=self.auth,
            headers=self.headers
        )
        return response.json()
    
    def search_customers(self, query):
        """Search for customers across leads and contacts"""
        params = {'q': query}
        response = requests.get(
            f'{self.base_url}/GlobalSearch',
            params=params,
            auth=self.auth
        )
        return response.json()

# Example usage for home service application
if __name__ == '__main__':
    # Initialize AI agent
    agent = EspoCRMAgent(
        base_url='https://your-espocrm.com',
        username='api_user',
        password='api_password'
    )
    
    # Example 1: Create a new lead from a service inquiry
    lead = agent.create_lead(
        first_name='Jane',
        last_name='Smith',
        email='jane.smith@example.com',
        phone='+1-555-0123'
    )
    print(f"Created lead: {lead['id']}")
    
    # Example 2: Schedule a plumbing service appointment
    appointment = agent.schedule_service_appointment(
        contact_id='existing_contact_id',
        service_type='Plumbing',
        date_time=datetime.now() + timedelta(days=2)
    )
    print(f"Scheduled appointment: {appointment['id']}")
    
    # Example 3: Create a task for technician
    task = agent.create_service_task(
        assigned_user_id='technician_user_id',
        service_details={
            'title': 'Fix kitchen sink leak',
            'description': 'Customer reported water leak under kitchen sink',
            'priority': 'High',
            'due_date': datetime.now() + timedelta(days=1)
        }
    )
    print(f"Created task: {task['id']}")
    
    # Example 4: Get this week's appointments
    appointments = agent.get_upcoming_appointments(days=7)
    print(f"Found {appointments['total']} upcoming appointments")
    
    # Example 5: Mark task as completed
    agent.update_task_status(task['id'], 'Completed')
    print("Task marked as completed")