class Todo {
    constructor() {
        this.tasks = [];
        this.loadTasks();
        this.draw();
        this.initEventListeners();
    }

    draw(searchTerm = '') {
        const taskList = document.getElementById('taskList');
        taskList.innerHTML = '';

        this.tasks.forEach((task, index) => {
            if (task.name.toLowerCase().includes(searchTerm.toLowerCase())) {
                const li = document.createElement('li');

                const taskText = document.createElement('span');
                taskText.innerHTML = this.highlightText(task.name, searchTerm) + (task.dueDate ? ` (do: ${new Date(task.dueDate).toLocaleString()})` : '');
                li.appendChild(taskText);

                const editInput = document.createElement('input');
                editInput.type = 'text';
                editInput.value = task.name;
                editInput.style.display = 'none';
                li.appendChild(editInput);

                const dueDateInput = document.createElement('input');
                dueDateInput.type = 'datetime-local';
                dueDateInput.value = task.dueDate ? new Date(task.dueDate).toISOString().slice(0, 16) : '';
                dueDateInput.style.display = 'none';
                li.appendChild(dueDateInput);

                const saveButton = document.createElement('button');
                saveButton.textContent = 'Zapisz';
                saveButton.style.display = 'none';
                li.appendChild(saveButton);

                taskText.addEventListener('click', () => {
                    taskText.style.display = 'none';
                    editInput.style.display = 'inline';
                    dueDateInput.style.display = 'inline';
                    saveButton.style.display = 'inline';
                    editInput.focus();
                });

                saveButton.addEventListener('click', () => {
                    const newName = editInput.value;
                    const newDueDate = dueDateInput.value;
                    if (newName.length >= 3 && newName.length <= 255 && (!newDueDate || new Date(newDueDate) > new Date())) {
                        this.tasks[index].name = newName;
                        this.tasks[index].dueDate = newDueDate;
                        this.saveTasks();
                        this.draw(searchTerm);
                    } else {
                        alert('Zadanie musi mieć od 3 do 255 znaków, a termin musi być w przyszłości lub pusty.');
                    }
                });

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Usuń';
                removeButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.tasks.splice(index, 1);
                    this.saveTasks();
                    this.draw(searchTerm);
                });
                li.appendChild(removeButton);
                taskList.appendChild(li);
            }
        });
    }

    highlightText(text, searchTerm) {
        if (!searchTerm) return text;
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return text.replace(regex, '<span style="background-color: yellow;">$1</span>');
    }

    addTask(name, dueDate) {
        this.tasks.push({ name, dueDate });
        this.saveTasks();
        this.draw();
    }

    saveTasks() {
        localStorage.setItem('tasks', JSON.stringify(this.tasks));
    }

    loadTasks() {
        const tasks = JSON.parse(localStorage.getItem('tasks'));
        if (tasks) {
            this.tasks = tasks;
        }
    }

    initEventListeners() {
        document.getElementById('addTask').addEventListener('click', () => {
            const taskName = document.getElementById('newTask').value;
            const dueDate = document.getElementById('dueDate').value;

            if (taskName.length >= 3 && taskName.length <= 255 && (!dueDate || new Date(dueDate) > new Date())) {
                this.addTask(taskName, dueDate);
                document.getElementById('newTask').value = '';
                document.getElementById('dueDate').value = '';
            } else {
                alert('Zadanie musi mieć od 3 do 255 znaków, a termin musi być w przyszłości lub pusty.');
            }
        });

        document.getElementById('search').addEventListener('input', () => {
            const term = document.getElementById('search').value;
            this.draw(term);
        });
    }
}

const todo = new Todo();
