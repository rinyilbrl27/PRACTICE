let notes = loadNotes();

document.getElementById('add-note-btn').addEventListener('click', addNote);

function addNote() {
    const noteInput = document.getElementById('note-input');
    const noteText = noteInput.value.trim();
    
    if (noteText !== '') {
        const timestamp = new Date().toLocaleString(); // ito yung code para sa current date and time.
        const noteWithTime = { text: noteText, time: timestamp }; // Ito naman ay nag ce Create nang  object to hold note text and time.

        try {
            notes.unshift(noteWithTime); //Ito po yung code na nag a Add nnag note object to the notes array
            noteInput.value = '';
            displayNotes();
            saveData();
        } catch (error) {
            console.error('Error adding note:', error);
        }
    }
}

function displayNotes() {
    const notesList = document.getElementById('notes-list');
    notesList.innerHTML = '';
    notes.forEach((note, index) => {
        const noteElement = document.createElement('div');
        noteElement.classList.add('note');
        noteElement.innerHTML = `
            <p>${note.text}</p>
            <button class="delete-btn" data-index="${index}">Delete</button>
            <button class="edit-btn" data-index="${index}">Edit</button>
            <small class="note-time">${note.time}</small> <!-- Display the date and time -->
        `;
        notesList.appendChild(noteElement);
    });

    document.querySelectorAll('.delete-btn').forEach((btn) => {
        btn.addEventListener('click', deleteNote);
    });

    document.querySelectorAll('.edit-btn').forEach((btn) => {
        btn.addEventListener('click', editNote);
    });
}

function deleteNote(event) {
    const index = event.target.dataset.index;
    try {
        notes.splice(index, 1);
        displayNotes();
        saveData();
    } catch (error) {
        console.error('Error deleting note:', error);
    }
}

function editNote(event) {
    const index = event.target.dataset.index;
    const newNoteText = prompt('Enter new note:', notes[index].text);
    if (newNoteText !== null && newNoteText.trim() !== '') {
        try {
            notes[index].text = newNoteText; // inuupdate nya lang ang text, ginagawa nya is kini-keep  nya yung original timestamp
            displayNotes();
            saveData();
        } catch (error) {
            console.error('Error editing note:', error);
        }
    }
}

function saveData() {
    try {
        localStorage.setItem('notes', JSON.stringify(notes));
    } catch (error) {
        console.error('Error saving data:', error);
    }
}

function loadNotes() {
    try {
        const storedNotes = localStorage.getItem('notes');
        return storedNotes ? JSON.parse(storedNotes) : [];
    } catch (error) {
        console.error('Error loading notes:', error);
        return [];
    }
}

displayNotes();
