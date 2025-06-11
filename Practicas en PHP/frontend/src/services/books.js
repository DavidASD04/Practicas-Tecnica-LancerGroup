import api from "./api"

export const booksService = {
  // Obtener todos los libros
  getAll() {
    return api.get("/books")
  },

  // Obtener un libro por ID
  getById(id) {
    return api.get(`/books/${id}`)
  },

  // Crear un nuevo libro
  create(data) {
    return api.post("/books", data)
  },

  // Actualizar un libro
  update(id, data) {
    return api.put(`/books/${id}`, data)
  },

  // Eliminar un libro
  delete(id) {
    return api.delete(`/books/${id}`)
  },

  // Obtener autores para selección
  getAuthorsForSelect() {
    return api.get("/books-authors")
  },
}
