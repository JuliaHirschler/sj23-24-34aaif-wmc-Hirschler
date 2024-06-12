class Books{
    #title;
    #author;
    #read;
    #bewertung;
    #kommentar;

    constructor(title, author, read, bewertung, kommentar) {
        this.#title = title;
        this.#author = author;
        this.#read = read;
        this.#bewertung = bewertung;
        this.#kommentar = kommentar;
    }

    set Title(text){
        if(typeof text !== 'string' || text === ""){
            console.log("Error");
            throw new Error("Titel nicht valide!")
        }
        this.#title = text;
    }

    get Title(){
        return this.#title;
    }

    get Author(){
        return this.#author;
    }

    get Read(){
        return this.#read;
    }

    get Bewertung(){
        return this.#bewertung;
    }

    get Kommentar(){
        return this.#kommentar;
    }
}
const state ={
    book:[
        new Books('Ein ganzes Leben', 'Robert Seeberger', true, 4, "Philosophisch, regt zum nachdenken an."),
        new Books('Der Stein der Weisen', 'JK Rolling', false, 2, "Spannend und lustig."),
        new Books('28 Tage lang', 'David Safir', true, 5 ,'Packend geschrieben, bringt einen zum weinen.')
    ]
};

//2.State accesor

function addNewBooktoShelf(title, author, read, bewertung, kommentar){
    state.book.push(new Books(title, author, read, bewertung, kommentar));

}

function deleteBook(books){
    let index = state.book.indexOf(books);
        if(index !== -1){
            state.book.splice(index,1);
        }

}
//3.
const bList = document.getElementById('book-list');
const bTitle = document.getElementById('title');
const bAuthor = document.getElementById('author');

const bRead = document.getElementById('read');
const bRating = document.getElementById('rating');
const bComment = document.getElementById('comment');
const bAddBtn = document.getElementById('addBook');
const bSortBtn = document.getElementById('sortBewertung');
const bDeleteBtn = document.getElementById('deletebtn');

//4.

function createBooks(books){
    const book = document.createElement('tr');

    const bookTitle = document.createElement('td');
    const bookAuthor= document.createElement('td');
    const bookRead= document.createElement('td');
    const bookBewertung = document.createElement('td');
    const bookKommentar = document.createElement('td');

    bookTitle.textContent = books.Title;
    bookAuthor.textContent = books.Author;
    bookRead.textContent = books.Read ? "True" : "False";
    bookBewertung.textContent = books.Bewertung;
    bookKommentar.textContent = books.Kommentar;

    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Delete';
    deleteBtn.addEventListener('click', (event) => deleteEntryBtn(books));

    book.appendChild(bookTitle);
    book.appendChild(bookAuthor);
    book.appendChild(bookRead);
    book.appendChild(bookBewertung);
    book.appendChild(bookKommentar);

    book.appendChild(deleteBtn);
    return book;
}

//5.

function render(){
    bList.innerHTML = '';
    const listBooks = state.book;
    listBooks.forEach(book => {
        bList.appendChild(createBooks(book));
    });
}
localStorage.setItem('state', JSON.stringify(state));

//6.
function addBookBtn(){
    event.preventDefault();
    addNewBooktoShelf(bTitle.value, bAuthor.value, bRead.value, bRating.value, bComment.value);
    render();
}

function deleteEntryBtn(books){
    deleteBook(books);
    render();
}

    function sortByRating() {
        state.book.sort((a, b) => b.Bewertung - a.Bewertung);
        render();
    }



bAddBtn.addEventListener('click', addBookBtn);
bDeleteBtn.addEventListener('click', deleteEntryBtn);
bSortBtn.addEventListener('click', sortByRating);

let stateStr = localStorage.getItem('state');
const state1 = stateStr ? JSON.parse(stateStr) : state;
render();

