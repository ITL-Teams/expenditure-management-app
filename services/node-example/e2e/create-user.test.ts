import { expect } from 'chai'
const fetch = require('node-fetch')

// TEST PARAMS
const HTTP_OPTIONS = {
  url: 'http://localhost/user/create',
  method: 'post',
  headers: {
    'Content-Type': 'application/json'
  }
}

// TEST EXPORT
export let USER_ID: string
export let USER_NAME: string

// TEST BODY
describe('CREATE USER: /user/create', function () {
  this.timeout(60000)

  it('success invocation usign valid name', async () => {
    const payload = {
      firstName: 'ricardo',
      lastName: 'ramirez'
    }

    HTTP_OPTIONS['body'] = JSON.stringify(payload)

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('success')
    expect(data.success).to.have.property('message')
    expect(data.success).to.have.property('id')

    expect(data.success.message).to.be.an('string')
    expect(data.success.id).to.be.an('string')

    expect(data.success.message).to.be.equals(
      `User: ${payload.firstName} ${payload.lastName} has been registered in db`
    )

    USER_ID = data.success.id
    USER_NAME = `${payload.firstName} ${payload.lastName}`
  })

  it('failed invocation, missing params', async () => {
    const payload = {
      firstName: 'ricardo'
    }

    HTTP_OPTIONS['body'] = JSON.stringify(payload)

    const fetch_response = await fetch(HTTP_OPTIONS.url, HTTP_OPTIONS)
    const data = await fetch_response.json()

    expect(data).to.have.property('error')
    expect(data.error).to.have.property('message')
    expect(data.error).to.have.property('reason')

    expect(data.error.message).to.be.an('string')
    expect(data.error.reason).to.be.an('string')

    expect(data.error.message).to.be.equals('User was not registered')
    expect(data.error.reason).to.be.equals(
      'RequestError: lastName is supposed to be string, but undefined was sent instead'
    )
  })
})
