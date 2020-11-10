import { Router } from 'express'
import { UserCreatorController } from '../controller/create-user/UserCreatorController'
import { UserDeleterController } from '../controller/delete-user/UserDeleterController'
import { UserFinderController } from '../controller/get-user/UserFinderController'
import { UserUpdaterController } from '../controller/update-user/UserUpdaterController'
import { MySqlUserRepository } from '../database/MySqlUserRepository'
export const router = Router()

const user_repository = new MySqlUserRepository()

router.post('/create', async (request, response) => {
  const controller = new UserCreatorController(user_repository)
  const controllerResponse = await controller.handler({
    firstName: request.body.firstName,
    lastName: request.body.lastName
  })

  response.json(controllerResponse)
})

router.get('/get/:userId', async (request, response) => {
  const controller = new UserFinderController(user_repository)
  const controllerResponse = await controller.handler({
    userId: request.params.userId
  })

  response.json(controllerResponse)
})

router.put('/update', async (request, response) => {
  const controller = new UserUpdaterController(user_repository)
  const controllerResponse = await controller.handler({
    firstName: request.body.firstName,
    lastName: request.body.lastName,
    userId: request.body.userId
  })

  response.json(controllerResponse)
})

router.delete('/delete/:userId', async (request, response) => {
  const controller = new UserDeleterController(user_repository)
  const controllerResponse = await controller.handler({
    userId: request.params.userId
  })

  response.json(controllerResponse)
})

router.all('*', (request, response) => {
  response.status(404).send()
})
