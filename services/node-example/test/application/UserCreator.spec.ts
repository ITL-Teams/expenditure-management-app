import { expect } from 'chai'
import { stub, SinonStub } from 'sinon'
import { name } from 'faker'
import { MockUserRepository } from './MockUserRepository'
import { UserCreator } from '../../src/application/create-user/UserCreator'
import { UserCreatorRequest } from '../../src/application/create-user/UserCreatorRequest'

let repository: MockUserRepository
let repository_stub: SinonStub

describe('User::Application::UserCreator', () => {
  before(() => {
    repository = new MockUserRepository()
  })

  it('invoke creator', async () => {
    repository_stub = stub(repository, 'create')

    const creator = new UserCreator(repository)
    const request: UserCreatorRequest = {
      firstName: name.firstName(),
      lastName: name.lastName()
    }

    const user = await creator.invoke(request)
    expect(repository_stub.calledOnce).to.be.true
    expect(user.getName().toString()).to.equal(
      `${request.firstName} ${request.lastName}`
    )
  })
})
