import { Router } from 'express'
import { MySqlUserRepository } from '../database/MySqlUserRepository'
import { UserRegisterController } from '../controller/user-register/UserRegisterController'
import { CredentialsValidatorController } from '../controller/credentials-validator/CredentialsValidatorController'
import { TwoFactorValidatorController } from '../controller/2fa/TwoFactorValidatorController'
export const router = Router()

const user_repository = new MySqlUserRepository()

router.post('/register', async (request, response) => {
  const controller = new UserRegisterController(user_repository)

  const controllerResponse = await controller.handler({
    email: request.body.email,
    firstName: request.body.firstName,
    lastName: request.body.lastName,
    password: request.body.password,
    signature: request.body.signature,
    enterprise_account: request.body.enterprise_account
  })

  response.json(controllerResponse)
})

router.post('/login', async (request, response) => {
  const controller = new CredentialsValidatorController(user_repository)

  const controllerResponse = await controller.handler({
    email: request.body.email,
    password: request.body.password
  })

  response.json(controllerResponse)
})

router.post('/2fa', async (request, response) => {
  const controller = new TwoFactorValidatorController(user_repository)

  const controllerResponse = await controller.handler({
    email: request.body.email,
    code: request.body.code
  })

  response.json(controllerResponse)
})

router.all('*', (request, response) => {
  response.status(404).send()
})
