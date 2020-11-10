import { expect } from 'chai'
const fetch = require('node-fetch')
import { USER_ID, USER_NAME } from './create-user.test'

// TEST PARAMS
const HTTP_OPTIONS = {
  url: 'http://localhost/user/update',
  method: 'put',
  headers: {
    'Content-Type': 'application/json'
  }
}

// TEST BODY
describe('CREATE USER: /user/create', function () {
  this.timeout(60000)

  it('success invocation usign valid name', async () => {
    const payload = {
      firstName: 'angel',
      lastName: 'ramirez',
      userId: USER_ID
    }

    HTTP_OPTIONS['body'] = JSON.stringify(payload)

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('success')
    expect(data.success).to.have.property('user')

    expect(data.success.user).to.have.property('id')
    expect(data.success.user).to.have.property('name')

    expect(data.success.user.id).to.be.an('string')
    expect(data.success.user.name).to.be.an('string')

    expect(data.success.user.id).to.be.equals(USER_ID)
    expect(data.success.user.name).to.be.equals(
      `${payload.firstName} ${payload.lastName}`
    )
  })

  it('failed invocation, missing params', async () => {
    const payload = {
      firstName: 'ricardo',
      userId: USER_ID
    }

    HTTP_OPTIONS['body'] = JSON.stringify(payload)

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('error')
    expect(data.error).to.have.property('message')
    expect(data.error).to.have.property('reason')

    expect(data.error.message).to.be.an('string')
    expect(data.error.reason).to.be.an('string')

    expect(data.error.message).to.be.equals('User was not updated')
    expect(data.error.reason).to.be.equals(
      'RequestError: lastName is supposed to be string, but undefined was sent instead'
    )
  })

  it('failed invocation, not valid id', async () => {
    const payload = {
      firstName: 'ricardo',
      lastName: 'ramirez',
      userId: `${USER_ID}2`
    }

    HTTP_OPTIONS['body'] = JSON.stringify(payload)

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('error')
    expect(data.error).to.have.property('message')
    expect(data.error).to.have.property('reason')

    expect(data.error.message).to.be.an('string')
    expect(data.error.reason).to.be.an('string')

    expect(data.error.message).to.be.equals('User was not updated')
    expect(data.error.reason).to.be.equals(
      `UserNotFoundError: with userId = ${payload.userId}`
    )
  })
})
