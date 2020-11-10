import { expect } from 'chai'
import { stub, SinonStub } from 'sinon'
import { MockUserRepository } from './MockUserRepository'
import { UserUpdater } from '../../src/application/update-user/UserUpdater'
import { name } from 'faker'
import { User } from '../../src/domain/entity/User'
import { UserName } from '../../src/domain/value-object/UserName'
import { UserUpdaterRequest } from '../../src/application/update-user/UserUpdaterRequest'

let repository: MockUserRepository
let repository_stub: SinonStub

describe('User::Application::UserUpdater', () => {
  repository = new MockUserRepository()
  const updater = new UserUpdater(repository)

  const user = new User(new UserName(name.firstName(), name.lastName()))

  repository_stub = stub(repository, 'update').returns(
    new Promise<boolean>((resolve) => resolve(true))
  )

  const request: UserUpdaterRequest = {
    userId: user.getId().toString(),
    firstName: user.getName().toString().split(' ')[0],
    lastName: user.getName().toString().split(' ')[1]
  }

  it('invoke updater', async () => {
    const response = await updater.invoke(request)
    expect(repository_stub.calledOnce).to.be.true
    expect(response.getId().toString()).to.equals(request.userId)
    expect(response.getName().toString()).to.equals(
      `${request.firstName} ${request.lastName}`
    )
  })

  it('throws UserNotFoundError', async () => {
    repository_stub.restore()
    repository_stub = stub(repository, 'update').returns(
      new Promise<boolean>((resolve) => resolve(false))
    )

    const updater = new UserUpdater(repository)
    const request: UserUpdaterRequest = {
      firstName: name.firstName(),
      lastName: name.lastName(),
      userId: new User(new UserName(name.firstName(), name.lastName()))
        .getId()
        .toString()
    }

    try {
      await updater.invoke(request)
      throw Error()
    } catch (error) {
      expect(new String(error).toString()).to.equals(
        `UserNotFoundError: with userId = ${request.userId}`
      )
    }

    expect(repository_stub.calledOnce).to.be.true
  })
})
