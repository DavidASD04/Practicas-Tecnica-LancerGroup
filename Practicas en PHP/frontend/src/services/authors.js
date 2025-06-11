import api from "./api"

export const authorsService = {
  // Obtener todos los autores
  getAll() {
    return api.get("/authors")
  },

  // Obtener un autor por ID
  getById(id) {
    return api.get(`/authors/${id}`)
  },

  // Crear un nuevo autor
  create(data) {
    return api.post("/authors", data)
  },

  // Actualizar un autor
  update(id, data) {
    return api.put(`/authors/${id}`, data)
  },

  // Eliminar un autor (soft delete)
  delete(id) {
    return api.delete(`/authors/${id}`)
  },
}
