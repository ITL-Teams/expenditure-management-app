import { RequestError } from './error/RequestError'

export abstract class Controller<TRequest, TResponse> {
  abstract handler(request: TRequest): Promise<TResponse>

  protected validateRequestParams(
    params: {
      value_name: string
      value: any
      expected: string
    }[]
  ): void {
    params.forEach((element) => {
      if (typeof element.value !== element.expected)
        throw new RequestError(
          `${element.value_name} is supposed to be ${
            element.expected
          }, but ${typeof element.value} was sent instead`
        )
    })
  }
}
