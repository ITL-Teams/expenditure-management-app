import { Router } from 'express'
export const router = Router()

router.all('*', (request, response) => {
  response.status(404).send()
})
