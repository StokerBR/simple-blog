import moment from 'moment';

export function useMoment(
  inp?: moment.MomentInput,
  strict?: boolean | undefined
) {
  return moment(inp, strict);
}
