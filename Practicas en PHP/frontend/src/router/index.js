import { createRouter, createWebHistory } from "vue-router"
import Home from "../views/Home.vue"
import Authors from "../views/Authors.vue"
import AuthorDetail from "../views/AuthorDetail.vue"
import AuthorForm from "../views/AuthorForm.vue"
import Books from "../views/Books.vue"
import BookDetail from "../views/BookDetail.vue"
import BookForm from "../views/BookForm.vue"

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/authors",
    name: "authors",
    component: Authors,
  },
  {
    path: "/authors/create",
    name: "author-create",
    component: AuthorForm,
  },
  {
    path: "/authors/:id",
    name: "author-detail",
    component: AuthorDetail,
    props: true,
  },
  {
    path: "/authors/:id/edit",
    name: "author-edit",
    component: AuthorForm,
    props: true,
  },
  {
    path: "/books",
    name: "books",
    component: Books,
  },
  {
    path: "/books/create",
    name: "book-create",
    component: BookForm,
  },
  {
    path: "/books/:id",
    name: "book-detail",
    component: BookDetail,
    props: true,
  },
  {
    path: "/books/:id/edit",
    name: "book-edit",
    component: BookForm,
    props: true,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
